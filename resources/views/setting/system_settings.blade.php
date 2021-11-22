@extends('layouts.dashboard')
@section('page-title')
    {{__('Settings')}}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
$lang=\App\Utility::getValByName('default_language');
@endphp
@section('page-title')
    {{__('Settings')}}
@endsection
@push('css-page')
    <link href="{{ asset('assets/default/render/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script-page')
    <script src="{{ asset('assets/default/render/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Settings')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{ __('Dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{__('Settings')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row justify-content-center mt-5 mb-1">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="setting-tab">
                                    <ul class="nav nav-pills mb-3" id="myTab3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="contact-tab4" data-toggle="tab" href="#site-setting" role="tab" aria-controls="" aria-selected="false">{{__('Site Setting')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#email-setting" role="tab" aria-controls="" aria-selected="false">{{__('Email Setting')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#payment-setting" role="tab" aria-controls="" aria-selected="false">{{__('Payment Setting')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#pusher-setting" role="tab" aria-controls="" aria-selected="false">{{__('Pusher Setting')}}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent2">
                                        <div class="tab-pane fade fade show active" id="site-setting" role="tabpanel" aria-labelledby="profile-tab3">
                                            <div class="company-setting-wrap">
                                                {{Form::model($settings,array('url'=>'settings','method'=>'POST','enctype' => "multipart/form-data"))}}
                                                <div class="card-body">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h5>{{__('Logo')}}</h5>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail h-150">
                                                                        <img src="{{$logo.'/logo.png'}}" alt="">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                                    <div>
                                                                        <span class="btn btn-primary btn-file">
                                                                            <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                            <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                            <input type="hidden">
                                                                            <input type="file" name="logo" id="logo">
                                                                        </span>
                                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <h5>{{__('Small Logo')}}</h5>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail h-150">
                                                                        <img src="{{$logo.'/small_logo.png'}}" alt="">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                                    <div>
                                                                        <span class="btn btn-primary btn-file">
                                                                            <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                            <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                            <input type="hidden">
                                                                            <input type="file" name="small_logo" id="small_logo">
                                                                        </span>
                                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <h5>{{__('Favicon')}}</h5>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail h-150">
                                                                        <img src="{{$logo.'/favicon.png'}}" alt="">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                                    <div>
                                                                        <span class="btn btn-primary btn-file">
                                                                            <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                            <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                            <input type="hidden">
                                                                            <input type="file" name="favicon" id="favicon">
                                                                        </span>
                                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-20">
                                                            @error('logo')
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                            @enderror
                                                        </div>
                                                        <div class="row mt-20">
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('title_text',__('Title Text')) }}
                                                                {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                                                @error('title_text')
                                                                <span class="invalid-title_text" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                                 </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('footer_text',__('Footer Text')) }}
                                                                {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                                                @error('footer_text')
                                                                <span class="invalid-footer_text" role="alert">
                                                                     <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('default_language',__('Default Language')) }}
                                                                <div class="changeLanguage">
                                                                    <select name="default_language" id="default_language" class="form-control selectric">
                                                                        @foreach(\App\Utility::languages() as $language)
                                                                            <option @if($lang == $language) selected @endif value="{{$language }}">{{Str::upper($language)}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                                </div>
                                                {{Form::close()}}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="email-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                            <div class="email-setting-wrap">
                                                {{Form::open(array('route'=>'email.settings','method'=>'post'))}}
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_driver',__('Mail Driver')) }}
                                                        {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                                        @error('mail_driver')
                                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_host',__('Mail Host')) }}
                                                        {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))}}
                                                        @error('mail_host')
                                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_port',__('Mail Port')) }}
                                                        {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                                        @error('mail_port')
                                                        <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_username',__('Mail Username')) }}
                                                        {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                                        @error('mail_username')
                                                        <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_password',__('Mail Password')) }}
                                                        {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                                        @error('mail_password')
                                                        <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_encryption',__('Mail Encryption')) }}
                                                        {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                        @error('mail_encryption')
                                                        <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_from_address',__('Mail From Address')) }}
                                                        {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                                        @error('mail_from_address')
                                                        <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        {{Form::label('mail_from_name',__('Mail From Name')) }}
                                                        {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                                        @error('mail_from_name')
                                                        <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                                </div>
                                                {{Form::close()}}
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment-setting" role="tabpanel">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="payment-setting-wrap">
                                                            {{Form::model($settings,['route'=>'payment.settings', 'method'=>'POST'])}}
                                                            <div class="form-text">
                                                                <h6>{{__("This detail will use for collect payment on invoice from clients. On invoice client will find out pay now button based on your below configuration.")}}</h6>
                                                            </div>
                                                            <div class="row card-body pb-0">
                                                                <div class="form-group col-md-6">
                                                                    {{Form::label('currency_symbol',__('Currency Symbol *')) }}

                                                                    {{Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','required'))}}
                                                                    @error('currency_symbol')
                                                                    <span class="invalid-currency_symbol" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    {{Form::label('currency',__('Currency *')) }}
                                                                    {{Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','required'))}}
                                                                    <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                                                    @error('currency')
                                                                    <span class="invalid-currency" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="card-header border-bottom-0 pb-0">
                                                                <h5>{{ __('Stripe') }}</h5>
                                                            </div>
                                                            <div class="row card-body pb-0">
                                                                <div class="form-group col-md-12">
                                                                    {{Form::label('is_enable_stripe',__('Enable Stripe'), ['class' => 'custom-toggle-btn']) }}
                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="enable_stripe" class="custom-switch-input" {{ env('ENABLE_STRIPE') == 'on' ? 'checked="checked"' : '' }}>
                                                                        <span class="custom-switch-indicator"></span>
                                                                    </label>

                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    {{Form::label('stripe_key',__('Stripe Key')) }}
                                                                    {{Form::text('stripe_key',env('STRIPE_KEY'),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                                                    @error('stripe_key')
                                                                    <span class="invalid-stripe_key" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    {{Form::label('stripe_secret',__('Stripe Secret')) }}
                                                                    {{Form::text('stripe_secret',env('STRIPE_SECRET'),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                                                    @error('stripe_secret')
                                                                    <span class="invalid-stripe_secret" role="alert">
                                                                 <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="card-header border-bottom-0 pb-0">
                                                                <h5>{{ __('Paypal') }}</h5>
                                                            </div>
                                                            <div class="row card-body pb-0">
                                                                <div class="form-group col-md-12">
                                                                    {{Form::label('enable_stripe',__('Enable Paypal'), ['class' => 'custom-toggle-btn']) }}

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="enable_paypal" class="custom-switch-input" {{ env('ENABLE_PAYPAL') == 'on' ? 'checked="checked"' : '' }}>
                                                                        <span class="custom-switch-indicator"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="paypal_mode">{{ __('Paypal Mode') }}</label>
                                                                    <div class="selectgroup w-50">
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="paypal_mode" value="sandbox" class="selectgroup-input" {{ env('PAYPAL_MODE') == '' || env('PAYPAL_MODE') == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                            <span class="selectgroup-button">{{ __('Sandbox') }}</span>
                                                                        </label>
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="paypal_mode" value="live" class="selectgroup-input" {{ env('PAYPAL_MODE') == 'live' ? 'checked="checked"' : '' }}>
                                                                            <span class="selectgroup-button">{{ __('Live') }}</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                                                    <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{env('PAYPAL_CLIENT_ID')}}" placeholder="{{ __('Client ID') }}"/>
                                                                    @if ($errors->has('paypal_client_id'))
                                                                        <span class="invalid-feedback d-block">
                                                        {{ $errors->first('paypal_client_id') }}
                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                                                    <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{env('PAYPAL_SECRET_KEY')}}" placeholder="{{ __('Secret Key') }}"/>
                                                                    @if ($errors->has('paypal_secret_key'))
                                                                        <span class="invalid-feedback d-block">
                                                        {{ $errors->first('paypal_secret_key') }}
                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                {{Form::submit(__('Save Changes'),['class'=>'btn btn-primary'])}}
                                                            </div>
                                                            {{Form::close()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="pusher-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                            <div class="stripe-setting-wrap">
                                                {{Form::open(array('route'=>'pusher.settings','method'=>'post'))}}

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('pusher_app_id',__('Pusher App Id')) }}
                                                        {{Form::text('pusher_app_id',env('PUSHER_APP_ID'),array('class'=>'form-control','placeholder'=>__('Enter Pusher App Id')))}}
                                                        @error('pusher_app_id')
                                                        <span class="invalid-pusher_app_id" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('pusher_app_key',__('Pusher App Key')) }}
                                                        {{Form::text('pusher_app_key',env('PUSHER_APP_KEY'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Key')))}}
                                                        @error('pusher_app_key')
                                                        <span class="invalid-pusher_app_key" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('pusher_app_secret',__('Pusher App Secret')) }}
                                                        {{Form::text('pusher_app_secret',env('PUSHER_APP_SECRET'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Secret')))}}
                                                        @error('pusher_app_secret')
                                                        <span class="invalid-pusher_app_secret" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('pusher_app_cluster',__('Pusher App Cluster')) }}
                                                        {{Form::text('pusher_app_cluster',env('PUSHER_APP_CLUSTER'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Cluster')))}}
                                                        @error('pusher_app_cluster')
                                                        <span class="invalid-pusher_app_cluster" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                                </div>
                                                {{Form::close()}}
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
