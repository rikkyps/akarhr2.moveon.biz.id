@extends('layouts.dashboard')
@section('page-title')
    {{__('Indicator')}}
@endsection
@push('script-page')
    <script>
        $(document).ready(function () {
            var d_id = $('#department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">{{__('Select Designation')}}</option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
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
                <h1>{{__('Manage Indicator')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Indicator')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Indicator List')}}</h4>
                                    @can('Create Indicator')
                                        <a href="#" data-url="{{ route('indicator.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-title="{{__('Create New Indicator')}}">
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
                                            <th>{{__('Added By')}}</th>
                                            <th>{{__('Created At')}}</th>
                                            @if( Gate::check('Edit Indicator') ||Gate::check('Delete Indicator') ||Gate::check('Show Indicator'))
                                                <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($indicators as $indicator)
                                            <tr>
                                                <td>{{ !empty($indicator->branches)?$indicator->branches->name:'' }}</td>
                                                <td>{{ !empty($indicator->departments)?$indicator->departments->name:'' }}</td>
                                                <td>{{ !empty($indicator->designations)?$indicator->designations->name:'' }}</td>
                                                <td>{{ !empty($indicator->user)?$indicator->user->name:'' }}</td>
                                                <td>{{ \Auth::user()->dateFormat($indicator->created_at) }}</td>
                                                @if( Gate::check('Edit Indicator') ||Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                                    <td class="text-right">
                                                        @can('Show Indicator')
                                                            <a href="#" data-url="{{ route('indicator.show',$indicator->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Indicator Detail')}}" class="btn btn-outline-warning
                                                             btn-sm mr-1"><i class="fas fa-eye"></i> <span>{{__('Show')}}</span></a>
                                                        @endcan
                                                        @can('Edit Indicator')
                                                            <a href="#" data-url="{{ route('indicator.edit',$indicator->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Indicator')}}" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                        @can('Delete Indicator')
                                                            <a href="#" class="btn btn-outline-danger btn-sm" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$indicator->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id],'id'=>'delete-form-'.$indicator->id]) !!}
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



