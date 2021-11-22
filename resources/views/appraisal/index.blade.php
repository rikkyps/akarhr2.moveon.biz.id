@extends('layouts.dashboard')
@section('page-title')
    {{__('Appraisal')}}
@endsection
@push('script-page')
    <script>
        $(document).ready(function () {
            var employee = $('#employee').val();
            getEmployee(employee);
        });

        $(document).on('change', 'select[name=branch]', function () {
            var branch = $(this).val();
            getEmployee(branch);
        });

        function getEmployee(did) {
            $.ajax({
                url: '{{route('branch.employee.json')}}',
                type: 'POST',
                data: {
                    "branch": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#employee').empty();
                    $('#employee').append('<option value="">{{__('Select Branch')}}</option>');
                    $.each(data, function (key, value) {
                        $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }


    </script>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Appraisal')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Appraisal')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Appraisal List')}}</h4>
                                    @can('Create Appraisal')
                                        <a href="#" data-url="{{ route('appraisal.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Appraisal')}}">
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
                                            <th>{{__('Department')}}</th>
                                            <th>{{__('Designation')}}</th>
                                            <th>{{__('Employee')}}</th>
                                            <th>{{__('Appraisal Date')}}</th>
                                            @if( Gate::check('Edit Appraisal') ||Gate::check('Delete Appraisal') ||Gate::check('Show Appraisal'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($appraisals as $appraisal)
                                            <tr>
                                                <td>{{ !empty($appraisal->branches)?$appraisal->branches->name:'' }}</td>
                                                <td>{{ !empty($appraisal->employees)?!empty($appraisal->employees->department)?$appraisal->employees->department->name:'':'' }}</td>
                                                <td>{{ !empty($appraisal->employees)?!empty($appraisal->employees->designation)?$appraisal->employees->designation->name:'':'' }}</td>
                                                <td>{{!empty($appraisal->employees)?$appraisal->employees->name:'' }}</td>
                                                <td>{{ $appraisal->appraisal_date}}</td>
                                                @if( Gate::check('Edit Appraisal') ||Gate::check('Delete Appraisal') ||Gate::check('Show Appraisal'))
                                                    <td class="text-right">
                                                        @can('Show Appraisal')
                                                            <a href="#" data-url="{{ route('appraisal.show',$appraisal->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Appraisal Detail')}}" class="btn btn-outline-warning btn-sm mr-1"><i class="fas fa-eye"></i> <span>{{__('Show')}}</span></a>
                                                        @endcan
                                                        @can('Edit Appraisal')
                                                            <a href="#" data-url="{{ route('appraisal.edit',$appraisal->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Appraisal')}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Appraisal')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$appraisal->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id],'id'=>'delete-form-'.$appraisal->id]) !!}
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



