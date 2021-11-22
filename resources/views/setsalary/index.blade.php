@extends('layouts.dashboard')
@section('page-title')
    {{__('Salary')}}
@endsection
@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Employee Salary')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Employee Salary')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Employee Salary')}}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Employee Id')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Payroll Type') }}</th>
                                            <th>{{__('Salary') }}</th>
                                            <th>{{__('Net Salary') }}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($employees as $employee)

                                            <tr>
                                                <td>{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->salary_type() }}</td>
                                                <td>{{  \Auth::user()->priceFormat($employee->salary) }}</td>
                                                <td>{{  !empty($employee->get_net_salary()) ?\Auth::user()->priceFormat($employee->get_net_salary()):'' }}</td>
                                                <td class="text-right">
                                                    <a href="{{route('setsalary.show',$employee->id)}}" class="btn btn-outline-warning btn-sm mr-1">
                                                        <i class="fas fa-eye"> <span>{{__('View')}}</span></i>
                                                    </a>
                                                    @can('Edit Set Salary')
                                                        <a href="{{ URL::to('setsalary/'.$employee->id.'/edit') }}" class="btn btn-outline-primary btn-sm mr-1">
                                                            <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                        </a>
                                                    @endcan
                                                    @can('Delete Set Salary')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['setsalary.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


