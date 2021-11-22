@extends('layouts.dashboard')
@push('script-page')

    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">
            @if($plan->price > 0.0 && env('ENABLE_STRIPE') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET')))
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    toastrs('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        @endif

        $(document).ready(function () {
            $(document).on('click', '.apply-coupon', function () {

                var ele = $(this);
                var coupon = ele.closest('.row').find('.coupon').val();

                $.ajax({
                    url: '{{route('apply.coupon')}}',
                    datType: 'json',
                    data: {
                        plan_id: '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}',
                        coupon: coupon
                    },
                    success: function (data) {
                        if (data != '') {
                            $('.final-price').text(data.final_price);
                            $('#stripe_coupon, #paypal_coupon').val(coupon);

                            if (data.is_success) {
                                show_msg('Success', data.message, 'success');
                            } else {
                                show_msg('Error', data.message, 'error');
                            }
                        } else {
                            show_msg('Error', "{{__('Coupon code required.')}}", 'error');
                        }
                    }
                })
            });
        });

    </script>
@endpush
@php
    $dir= asset(Storage::url('uploads/plan'));
    $dir_payment= asset(Storage::url('uploads/payments'));
@endphp
@section('page-title')
    {{__('Order Summary')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Order Summary')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('plans.index') }}">{{__('Plan')}}</a></div>
                    <div class="breadcrumb-item">{{__('Order Summary')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Manage Order Summary')}}</h4>
                                    @can('Create Plan')
                                        <a href="#" data-url="{{ route('plans.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Plan')}}" data-original-title="{{__('Create Plan')}}">
                                            <i class="fa fa-plus"></i> {{__('Create')}}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row plan-div">
                                    <div class="col-md-4">
                                        <div class="plan-item">
                                            <h4 class="font-style"> {{$plan->name}}</h4>
                                            <div class="img-wrap">
                                                @if(!empty($plan->image))
                                                    <img class="plan-img" src="{{$dir.'/'.$plan->image}}">
                                                @endif
                                            </div>
                                            <h3 class="final-price">
                                                {{env('CURRENCY_SYMBOL').$plan->price}}
                                            </h3>
                                            <div class="text-center">

                                            </div>
                                            <p class="font-style">{{$plan->duration}}</p>

                                            <ul>
                                                <li>
                                                    <i class="fas fa-user-tie"></i>
                                                    <p>{{$plan->max_users}} {{__('Users')}}</p>
                                                </li>
                                                <li>
                                                    <i class="fas fa-user-plus"></i>
                                                    <p>{{$plan->max_customers}} {{__('Customers')}}</p>
                                                </li>
                                                <li>
                                                    <i class="fas fa-user-plus"></i>
                                                    <p>{{$plan->max_venders}} {{__('Venders')}}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if((env('ENABLE_STRIPE') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET'))) && (env('ENABLE_PAYPAL') == 'on' && !empty(env('PAYPAL_CLIENT_ID')) && !empty(env('PAYPAL_SECRET_KEY'))))
                                                        <ul class="nav nav-pills" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-toggle="tab" href="#stripe-payment" role="tab" aria-controls="stripe" aria-selected="true">{{ __('Stripe') }}</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#paypal-payment" role="tab" aria-controls="paypal" aria-selected="false">{{ __('Paypal') }}</a>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content mt-3">
                                                    @if(env('ENABLE_STRIPE') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET')))
                                                        <div class="tab-pane fade {{ ((env('ENABLE_STRIPE') == 'on' && env('ENABLE_PAYPAL') == 'on') || env('ENABLE_STRIPE') == 'on') ? "show active" : "" }}" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment">
                                                            <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" id="payment-form">
                                                                @csrf
                                                                <div class="border p-3 mb-3 rounded stripe-payment-div">
                                                                    <div class="row">
                                                                        <div class="col-sm-8">
                                                                            <div class="custom-radio">
                                                                                <label class="font-16 font-weight-bold">{{__('Credit / Debit Card')}}</label>
                                                                            </div>
                                                                            <p class="mb-0 pt-1">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')}}</p>
                                                                        </div>
                                                                        <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                                                            <img src="{{asset('public/assets/img/payments/master.png')}}" height="24" alt="master-card-img">
                                                                            <img src="{{asset('public/assets/img/payments/discover.png')}}" height="24" alt="discover-card-img">
                                                                            <img src="{{asset('public/assets/img/payments/visa.png')}}" height="24" alt="visa-card-img">
                                                                            <img src="{{asset('public/assets/img/payments/american express.png')}}" height="24" alt="american-express-card-img">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="card-name-on">{{__('Name on card')}}</label>
                                                                                <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="{{\Auth::user()->name}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div id="card-element">
                                                                                <!-- A Stripe Element will be inserted here. -->
                                                                            </div>
                                                                            <div id="card-errors" role="alert"></div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <br>
                                                                            <div class="form-group">
                                                                                <label for="stripe_coupon">{{__('Coupon')}}</label>
                                                                                <input type="text" id="stripe_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 coupon-apply-btn">
                                                                            <div class="form-group apply-stripe-btn-coupon">
                                                                                <a href="#" class="btn btn-primary coupon-apply-btn apply-coupon">{{ __('Apply') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="error" style="display: none;">
                                                                                <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end Credit/Debit Card box-->
                                                                <div class="row mt-3">
                                                                    <div class="col-sm-12">
                                                                        <div class="text-sm-right">
                                                                            <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                                            <button class="btn btn-primary" type="submit">
                                                                                <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    @if(env('ENABLE_PAYPAL') == 'on' && !empty(env('PAYPAL_CLIENT_ID')) && !empty(env('PAYPAL_SECRET_KEY')))
                                                        <div class="tab-pane fade {{ (env('ENABLE_STRIPE') == 'off' && env('ENABLE_PAYPAL') == 'on') ? "show active" : "" }}" id="paypal-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                                            <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form" action="{{ route('plan.pay.with.paypal') }}">
                                                                @csrf
                                                                <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                                                <div class="border p-3 mb-3 rounded">
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <label for="paypal_coupon">{{__('Coupon')}}</label>
                                                                                <input type="text" id="paypal_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 coupon-apply-btn">
                                                                            <div class="form-group apply-paypal-btn-coupon">
                                                                                <a href="#" class="btn btn-primary apply-coupon">{{ __('Apply') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <div class="text-sm-right">
                                                                        <button class="btn btn-primary" type="submit">
                                                                            <i class="mdi mdi-cash-multiple mr-1"></i> {{__('Pay Now')}}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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

