@extends('layouts.dashboard')
@section('page-title')
    {{__('Account Statement')}}
@endsection
@push('script-page')
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Account Statement')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Account Statement')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.account.statement'),'method'=>'get')) }}
                                <div class="row">
                                    <div class="col">
                                        <h4 class="h4 mb-0">{{__('Filter')}}</h4>
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('start_month',__('Start Month'))}}
                                        {{Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:'',array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{Form::label('end_month',__('End Month'))}}
                                        {{Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:'',array('class'=>'form-control'))}}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('account', __('Account')) }}
                                        {{ Form::select('account', $accountList,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select2')) }}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('type', __('Type')) }}
                                        <select class="form-control select2" id="type" name="type">
                                            <option value="income" {{(isset($_GET['account']) && $_GET['type']=='income')?'selected':''}}>{{__('Income')}}</option>
                                            <option value="expense" {{(isset($_GET['account']) && $_GET['type']=='expense')?'selected':''}}>{{__('Expense')}}</option>
                                        </select>
                                    </div>

                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.account.statement')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
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
                                            <th>{{__('Account')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($accountData as $account)
                                            <tr>
                                                <td>{{!empty($account->accounts)?$account->accounts->account_name:''}}</td>
                                                <td>{{\Auth::user()->dateFormat($account->date)}}</td>
                                                <td>{{\Auth::user()->priceFormat($account->amount)}}</td>
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

