@extends('layouts.dashboard')
@section('page-title')
    {{__('Income Vs Expense')}}
@endsection
@push('script-page')
    <script>
        var BarsChart = (function () {
            var $chart = $('#chart-finance');

            function initChart($chart) {
                var ordersChart = new Chart($chart, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($labels) !!},
                        datasets:  {!! json_encode($data) !!}
                    }
                });
                $chart.data('chart', ordersChart);
            }
            if ($chart.length) {
                initChart($chart);
            }
        })();
    </script>

@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Income Vs Expense')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Income vs Expense Report')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                {{ Form::open(array('route' => array('report.income-expense'),'method'=>'get')) }}
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

                                    <div class="col-auto apply-btn">
                                        {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                        <a href="{{route('report.income-expense')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body min-height">
                                <div class="chart">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="chart-finance" class="chart-canvas chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                            <div class="project-details" style="margin-top: 15px;">
                                <div class="row mb-5 mt-5">
                                    <div class="col text-center">
                                        <div class="tx-gray-500 small"><h4>{{__('Total Income')}}</h4></div>
                                        <div class="font-weight-bold">{{\Auth::user()->priceFormat($incomeCount)}}</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="tx-gray-500 small"><h4>{{__('Total Expense')}}</h4></div>
                                        <div class="font-weight-bold">{{\Auth::user()->priceFormat($expenseCount)}}</div>
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

