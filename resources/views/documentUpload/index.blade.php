@extends('layouts.dashboard')
@section('page-title')
    {{__('Document')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Document')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Document')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Document List')}}</h4>
                                    @can('Create Document')
                                        <a href="#" data-url="{{ route('document-upload.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New  Document Type')}}" data-original-title="{{__('Create Document')}}">
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
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Document')}}</th>
                                            <th>{{__('Role')}}</th>
                                            <th>{{__('Description')}}</th>
                                            @if(Gate::check('Edit Document') || Gate::check('Delete Document'))
                                                <th class="text-right">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($documents as $document)
                                            @php
                                                $documentPath=asset(Storage::url('uploads/documentUpload'));
                                                   $roles = \Spatie\Permission\Models\Role::find($document->role);
                                            @endphp
                                            <tr>
                                                <td>{{ $document->name }}</td>
                                                <td>
                                                    @if(!empty($document->document))
                                                        <a href="{{$documentPath.'/'.$document->document}}" target="_blank">
                                                            <img src="{{$documentPath.'/'.$document->document}}" alt="No Document" width="100px" height="100px">
                                                        </a>
                                                    @else
                                                        <p>---</p>
                                                    @endif
                                                </td>
                                                <td>{{ !empty($roles)?$roles->name:'All' }}</td>
                                                <td>{{ $document->description }}</td>
                                                @if(Gate::check('Edit Document') || Gate::check('Delete Document'))
                                                    <td class="text-right">
                                                        @can('Edit Document')
                                                            <a href="#" data-url="{{ route('document-upload.edit',$document->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Document')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Document')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$document->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['document-upload.destroy', $document->id],'id'=>'delete-form-'.$document->id]) !!}
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

