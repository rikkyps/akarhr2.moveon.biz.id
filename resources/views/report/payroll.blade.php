@extends('layouts.dashboard')
@section('page-title')
    {{__('Payroll')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Payroll')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Payroll')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.payroll'),'method'=>'get')) }}
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('month',__('Month'))}}
                                        {{Form::month('month',isset($_GET['month'])?$_GET['month']:'',array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('employee', __('Employee')) }}
                                        {{ Form::select('employee', $employeesList,isset($_GET['employee'])?$_GET['employee']:'', array('class' => 'form-control select2')) }}
                                    </div>
                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.payroll')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="project-details">
                                <div class="row mt-5">
                                    <div class="col text-center">
                                        <div class="tx-gray-500 small"><h5>{{__('Total Basic Salary')}}</h5></div>
                                        <div class="font-weight-bold">{{\Auth::user()->priceFormat($totalBasicSalary)}}</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="tx-gray-500 small"><h5>{{__('Total Net Salary')}}</h5></div>
                                        <div class="font-weight-bold">{{\Auth::user()->priceFormat($totalNetSalary)}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive py-4">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>{{__('Employee ID')}}</th>
                                            <th>{{__('Employee')}}</th>
                                            <th>{{__('Salary')}}</th>
                                            <th>{{__('Net Salary')}}</th>
                                            <th>{{__('Month')}}</th>
                                            <th>{{__('Status')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payslips as $payslip)
                                            <tr>
                                                <td><a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($payslip->employee_id))}}" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($payslip->employee_id) }}</a></td>
                                                <td>{{(!empty($payslip->employees)) ? $payslip->employees->name:''}}</td>
                                                <td>{{\Auth::user()->priceFormat($payslip->basic_salary)}}</td>
                                                <td>{{\Auth::user()->priceFormat($payslip->net_payble)}}</td>
                                                <td>{{$payslip->salary_month}}</td>
                                                <td>
                                                    @if($payslip->status==0)
                                                        <div class="badge badge-danger"><a href="#" class="text-white">{{__('UnPaid')}}</a></div>
                                                    @else
                                                        <div class="badge badge-success"><a href="#" class="text-white">{{__('Paid')}}</a></div>
                                                    @endif
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

