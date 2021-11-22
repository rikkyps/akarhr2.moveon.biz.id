@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee Profile')}}
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Employee Profile')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Employee Profile')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="staff-wrap">
                                    {{ Form::open(array('route' => array('employee.profile'),'method' => 'GET')) }}
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            {{ Form::label('branch', __('Branch')) }}
                                            {{ Form::select('branch',$brances,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control font-style select2','data-toggle'=>"select2")) }}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {{ Form::label('department', __('Department')) }}
                                            {{ Form::select('department',$departments,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control font-style select2','data-toggle'=>"select2")) }}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {{ Form::label('designation', __('Designation')) }}
                                            <select class="select2 form-control select2-multiple" id="designation_id" name="designation" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                                <option value="">{{__('Designation')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                        <a href="{{route('employee.profile')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                    </div>
                                    {{ Form::close() }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Manage Employee Profile')}}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="staff-wrap">
                                    <div class="row">
                                        @forelse($employees as $employee)
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <div class="staff staff-grid-view pb-0">
                                                    <div class="contact-img">
                                                        <img src="{{!empty($employee->user->avatar) ? asset(Storage::url('uploads/avatar')).'/'.$employee->user->avatar : asset(Storage::url('uploads/avatar')).'/avatar.png'}}">
                                                    </div>
                                                    <div class="main-info mb-4">
                                                        <h2 class="m-0">{{ $employee->name }}</h2>
                                                        <p>{{ !empty($employee->designation)?$employee->designation->name:'' }}</p>
                                                    </div>
                                                    @can('Show Employee Profile')
                                                        <div class="meta-info mb-3">
                                                            <a href="{{route('show.employee.profile',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                                        </div>
                                                    @else
                                                        <div class="meta-info mb-3">
                                                            <a href="#" class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h6>{{__('there is no employee')}}</h6>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
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
            var d_id = $('#department').val();
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

