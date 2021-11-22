@extends('layouts.dashboard')
@section('page-title')
    {{__('Company Policy')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Company Policy')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Company Policy')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Company Policy List')}}</h4>
                                    @can('Create Company Policy')
                                        <a href="#" data-url="{{ route('company-policy.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Company Policy')}}">
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
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th>{{__('Attachment')}}</th>
                                            @if(Gate::check('Edit Company Policy') || Gate::check('Delete Company Policy'))
                                                <th class="text-right">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($companyPolicy as $policy)

                                            @php
                                                $policyPath=asset(Storage::url('uploads/companyPolicy'));
                                            @endphp
                                            <tr>
                                                <td>{{ !empty($policy->branches)?$policy->branches->name:'' }}</td>
                                                <td>{{ $policy->title }}</td>
                                                <td>{{ $policy->description }}</td>
                                                <td>
                                                    @if(!empty($policy->attachment))
                                                        <a href="{{$policyPath.'/'.$policy->attachment}}" target="_blank">
                                                            <img src="{{$policyPath.'/'.$policy->attachment}}" alt="No Attachment" width="100px" height="100px">
                                                        </a>
                                                    @else
                                                        <p>---</p>
                                                    @endif
                                                </td>
                                                @if(Gate::check('Edit Company Policy') || Gate::check('Delete Company Policy'))
                                                    <td class="text-right">
                                                        @can('Edit Company Policy')
                                                            <a href="#" data-url="{{ route('company-policy.edit',$policy->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Company Policy')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Company Policy')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$policy->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['company-policy.destroy', $policy->id],'id'=>'delete-form-'.$policy->id]) !!}
                                                            {!! Form::close() !!}
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

