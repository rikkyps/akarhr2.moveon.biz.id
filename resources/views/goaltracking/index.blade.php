@extends('layouts.dashboard')
@section('page-title')
    {{__('Goal Tracking')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Goal Tracking')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Goal Tracking')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Goal Tracking List')}}</h4>
                                    @can('Create Goal Tracking')
                                        <a href="#" data-url="{{ route('goaltracking.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Goal Tracking')}}">
                                            <i class="fa fa-plus"></i> {{__('Create')}}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Goal Type')}}</th>
                                            <th>{{__('Subject')}}</th>
                                            <th>{{__('Branch')}}</th>
                                            <th>{{__('Target Achievement')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th width="20%">{{__('Progress')}}</th>
                                            @if( Gate::check('Edit Goal Tracking') ||Gate::check('Delete Goal Tracking'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($goalTrackings as $goalTracking)

                                            <tr>
                                                <td>{{ !empty($goalTracking->goalType)?$goalTracking->goalType->name:'' }}</td>
                                                <td>{{$goalTracking->subject}}</td>
                                                <td>{{ !empty($goalTracking->branches)?$goalTracking->branches->name:'' }}</td>
                                                <td>{{$goalTracking->target_achievement}}</td>
                                                <td>{{\Auth::user()->dateFormat($goalTracking->start_date)}}</td>
                                                <td>{{\Auth::user()->dateFormat($goalTracking->end_date)}}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" style="width:{{$goalTracking->progress}}%">{{$goalTracking->progress}}%</div>
                                                    </div>
                                                </td>
                                                @if( Gate::check('Edit Goal Tracking') ||Gate::check('Delete Goal Tracking'))
                                                    <td class="text-right">
                                                        @can('Edit Goal Tracking')
                                                            <a href="#" data-url="{{ route('goaltracking.edit',$goalTracking->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Goal Tracking')}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Goal Tracking')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$goalTracking->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id],'id'=>'delete-form-'.$goalTracking->id]) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
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



