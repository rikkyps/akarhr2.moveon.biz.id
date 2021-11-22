@extends('layouts.dashboard')
@section('page-title')
    {{__('Leave')}}
@endsection
@push('script-page')


@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Leave')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Leave')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.leave'),'method'=>'get')) }}
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('employee', __('Employee')) }}
                                        {{ Form::select('employee', $employeesList,isset($_GET['employee'])?$_GET['employee']:'', array('class' => 'form-control select2')) }}
                                    </div>

                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.leave')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                            <th>{{__('Employee')}}</th>
                                            <th>{{__('Approved Leaves')}}</th>
                                            <th>{{__('Rejected Leaves')}}</th>
                                            <th>{{__('Pending Leaves')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leaves as $leave)
                                            <tr>
                                                <td>{{$leave['employee']}}</td>
                                                <td>

                                                    <a href="#!" data-url="{{ route('report.employee.leave',[$leave['id'],'Approve']) }}" data-ajax-popup="true" data-title="{{__('Approved Leave Detail')}}" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                                        <span class="badge badge-success mr-2">{{$leave['approved']}}</span> <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="#!" data-url="{{ route('report.employee.leave',[$leave['id'],'Reject']) }}" class="table-action table-action-delete" data-ajax-popup="true" data-title="{{__('Rejected Leave Detail')}}" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                                        <span class="badge badge-danger mr-2">{{$leave['reject']}}</span> <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="#!" data-url="{{ route('report.employee.leave',[$leave['id'],'Pending']) }}" class="table-action table-action-delete" data-ajax-popup="true" data-title="{{__('Pending Leave Detail')}}" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                                        <span class="badge badge-primary mr-2">{{$leave['pending']}}</span> <i class="fas fa-eye"></i>
                                                    </a>
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

