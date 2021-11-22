@extends('layouts.dashboard')
@section('page-title')
    {{__('Timesheet')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Timesheet')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Timesheet')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.timesheet'),'method'=>'get')) }}
                                <div class="row">
                                    <div class="col">
                                        <h5 class="h5 mb-0">{{__('Filter')}}</h5>
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('start_date',__('Start Date'))}}
                                        {{Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']:'',array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('end_date',__('End Date'))}}
                                        {{Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']:'',array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('employee', __('Employee')) }}
                                        {{ Form::select('employee', $employeesList,isset($_GET['employee'])?$_GET['employee']:'', array('class' => 'form-control select2')) }}
                                    </div>
                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.timesheet')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive py-4">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>{{__('Employee ID')}}</th>
                                            <th>{{__('Employee')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Hours')}}</th>
                                            <th>{{__('Description')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($timesheets as $timesheet)
                                            <tr>
                                                <td><a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($timesheet->employee_id))}}" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($timesheet->employee_id) }}</a></td>
                                                <td>{{(!empty($timesheet->employees)) ? $timesheet->employees->name:''}}</td>
                                                <td>{{\Auth::user()->dateFormat($timesheet->date)}}</td>
                                                <td>{{$timesheet->hours}}</td>
                                                <td>{{$timesheet->remark}}</td>
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

