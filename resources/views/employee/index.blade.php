@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Employee')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Employee')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Manage Employee')}}</h4>
                                    @can('Create Employee')
                                        <a href="{{ route('employee.create') }}" class="btn btn-icon icon-left btn-primary">
                                            <i class="fa fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Employee ID')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Branch') }}</th>
                                            <th>{{__('Department') }}</th>
                                            <th>{{__('Designation') }}</th>
                                            <th>{{__('Date Of Joining') }}</th>
                                            @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>
                                                    @can('Show Employee')
                                                        <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                                    @else
                                                        <a href="#" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                                    @endcan
                                                </td>
                                                <td class="font-style">{{ $employee->name }}</td>
                                                <td>{{ $employee->email }}</td>
                                                <td class="font-style">{{!empty(\Auth::user()->getBranch($employee->branch_id ))?\Auth::user()->getBranch($employee->branch_id )->name:''}}</td>
                                                <td class="font-style">{{!empty(\Auth::user()->getDepartment($employee->department_id ))?\Auth::user()->getDepartment($employee->department_id )->name:''}}</td>
                                                <td class="font-style">{{!empty(\Auth::user()->getDesignation($employee->designation_id ))?\Auth::user()->getDesignation($employee->designation_id )->name:''}}</td>
                                                <td class="font-style">{{ \Auth::user()->dateFormat($employee->company_doj )}}</td>
                                                @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                                    <td class="text-right">
                                                        @if($employee->is_active==1)
                                                            @can('Edit Employee')
                                                                {{--                                                                <a href="{{ URL::to('employee/'.$employee->id.'/edit') }}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>--}}
                                                                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                            @endcan
                                                            @can('Delete Employee')
                                                                <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        @else
                                                            <i class="fas fa-lock"></i>
                                                        @endif
                                                    </td>
                                                @endif
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


