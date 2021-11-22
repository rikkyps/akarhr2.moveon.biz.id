@extends('layouts.dashboard')
@section('page-title')
    {{__('Trainer')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Trainer')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Trainer')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Trainer List')}}</h4>
                                    @can('Create Trainer')
                                        <a href="#" data-url="{{ route('trainer.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Trainer')}}">
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
                                            <th>{{__('Branch')}}</th>
                                            <th>{{__('Full Name')}}</th>
                                            <th>{{__('Contact')}}</th>
                                            <th>{{__('Email')}}</th>
                                            @if( Gate::check('Edit Trainer') ||Gate::check('Delete Trainer') ||Gate::check('Show Trainer'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($trainers as $trainer)
                                            <tr>
                                                <td>{{ !empty($trainer->branches)?$trainer->branches->name:'' }}</td>
                                                <td>{{$trainer->firstname .' '.$trainer->lastname}}</td>
                                                <td>{{$trainer->contact}}</td>
                                                <td>{{$trainer->email}}</td>
                                                @if( Gate::check('Edit Trainer') ||Gate::check('Delete Trainer') || Gate::check('Show Trainer'))
                                                    <td class="text-right">
                                                        @can('Show Trainer')
                                                            <a href="#" data-url="{{ route('trainer.show',$trainer->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Trainer Detail')}}" class="btn btn-outline-warning btn-sm mr-1"><i class="fas fa-eye"></i> <span>{{__('Show')}}</span></a>
                                                        @endcan
                                                        @can('Edit Trainer')
                                                            <a href="#" data-url="{{ route('trainer.edit',$trainer->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Trainer')}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Trainer')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$trainer->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['trainer.destroy', $trainer->id],'id'=>'delete-form-'.$trainer->id]) !!}
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



