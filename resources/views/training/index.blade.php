@extends('layouts.dashboard')
@section('page-title')
    {{__('Training')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Training')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Training')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Training List')}}</h4>
                                    @can('Create Training')
                                        <a href="#" data-url="{{ route('training.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Training')}}">
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
                                            <th>{{__('Training Type')}}</th>
                                            <th>{{__('Employee')}}</th>
                                            <th>{{__('Trainer')}}</th>
                                            <th>{{__('Training Duration')}}</th>
                                            <th>{{__('Cost')}}</th>
                                            @if( Gate::check('Edit Training') ||Gate::check('Delete Training') ||Gate::check('Show Training'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($trainings as $training)
                                            <tr>
                                                <td>{{ !empty($training->branches)?$training->branches->name:'' }}</td>
                                                <td>{{ !empty($training->types)?$training->types->name:'' }} <br>

                                                    @if($training->status == 0)
                                                        <span class="text-warning">{{ __($status[$training->status]) }}</span>
                                                    @elseif($training->status == 1)
                                                        <span class="text-primary">{{ __($status[$training->status]) }}</span>
                                                    @elseif($training->status == 2)
                                                        <span class="text-success">{{ __($status[$training->status]) }}</span>
                                                    @elseif($training->status == 3)
                                                        <span class="text-info">{{ __($status[$training->status]) }}</span>
                                                    @endif

                                                </td>
                                                <td>{{ !empty($training->employees)?$training->employees->name:'' }} </td>
                                                <td>{{ !empty($training->trainers)?$training->trainers->firstname:'' }}</td>
                                                <td>{{\Auth::user()->dateFormat($training->start_date) .' to '.\Auth::user()->dateFormat($training->end_date)}}</td>
                                                <td>{{\Auth::user()->priceFormat($training->training_cost)}}</td>
                                                @if( Gate::check('Edit Training') ||Gate::check('Delete Training') || Gate::check('Show Training'))
                                                    <td class="text-right">
                                                        @can('Show Training')
                                                            <a href="{{ route('training.show',\Illuminate\Support\Facades\Crypt::encrypt($training->id)) }}" class="btn btn-outline-warning btn-sm mr-1"><i class="fas fa-eye"></i> <span>{{__('Show')}}</span></a>
                                                        @endcan
                                                        @can('Edit Training')
                                                            <a href="#" data-url="{{ route('training.edit',$training->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Training')}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Training')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$training->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['training.destroy', $training->id],'id'=>'delete-form-'.$training->id]) !!}
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



