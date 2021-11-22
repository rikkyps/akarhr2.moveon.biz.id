@extends('layouts.dashboard')
@section('page-title')
    {{__('Daily Attendance')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Daily Attendance')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Daily Attendance')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.daily.attendance'),'method'=>'get')) }}
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('date',__('Date'))}}
                                        {{Form::date('date',isset($_GET['date'])?$_GET['date']:date('Y-m-d'),array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('employee', __('Employee')) }}
                                        {{ Form::select('employee', $employeesList,isset($_GET['employee'])?$_GET['employee']:'', array('class' => 'form-control select2')) }}
                                    </div>
                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.daily.attendance')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                            <th>{{__('Clock In')}}</th>
                                            <th>{{__('Clock Out')}}</th>
                                            <th>{{__('Late')}}</th>
                                            <th>{{__('Early Leaving')}}</th>
                                            <th>{{__('Overtime')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($attendances as $attendance)
                                            <tr>
                                                <td><a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($attendance->employee_id))}}" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($attendance->employee_id) }}</a></td>
                                                <td>{{(!empty($attendance->employees)) ? $attendance->employees->name:''}}</td>
                                                <td>{{\Auth::user()->dateFormat($attendance->date)}}</td>
                                                <td>{{\Auth::user()->timeFormat($attendance->clock_in)}}</td>
                                                <td>{{\Auth::user()->timeFormat($attendance->clock_out)}}</td>
                                                <td>{{$attendance->late}}</td>
                                                <td>{{$attendance->early_leaving}}</td>
                                                <td>{{$attendance->overtime}}</td>
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

