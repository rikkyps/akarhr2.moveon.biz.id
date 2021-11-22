@extends('layouts.dashboard')
@section('page-title')
    {{__('Assets')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Assets')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Assets')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Assets List')}}</h4>
                                    @can('Create Assets')
                                        <a href="#" data-url="{{ route('account-assets.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create Assets')}}">
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
                                            <th> {{__('Name')}}</th>
                                            <th> {{__('Purchase Date')}}</th>
                                            <th> {{__('Support Until')}}</th>
                                            <th> {{__('Amount')}}</th>
                                            <th> {{__('Description')}}</th>
                                            @if(Gate::check('Edit Assets') || Gate::check('Delete Assets'))
                                                <th class="text-right"> {{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($assets as $asset)
                                            <tr>
                                                <td class="font-style">{{ $asset->name }}</td>
                                                <td class="font-style">{{ \Auth::user()->dateFormat($asset->purchase_date) }}</td>
                                                <td class="font-style">{{ \Auth::user()->dateFormat($asset->supported_date) }}</td>
                                                <td class="font-style">{{ \Auth::user()->priceFormat($asset->amount) }}</td>
                                                <td class="font-style">{{ $asset->description }}</td>
                                                @if(Gate::check('Edit Assets') || Gate::check('Delete Assets'))
                                                    <td class="action text-right">
                                                        @can('Edit Assets')
                                                            <a href="#" class="btn btn-outline-primary btn-sm mr-1" data-url="{{ route('account-assets.edit',$asset->id) }}" data-ajax-popup="true" data-title="{{__('Edit Assets')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                            </a>
                                                        @endcan
                                                        @can('Delete Assets')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$asset->id}}').submit();">
                                                                <i class="fas fa-trash"></i> <span>{{__('Delete')}}</span>
                                                            </a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id],'id'=>'delete-form-'.$asset->id]) !!}
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

@push('script-page')
    <script>
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
    </script>
@endpush
