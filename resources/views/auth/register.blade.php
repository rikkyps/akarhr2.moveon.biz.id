@extends('layouts.login-reg')
@section('page-title')
    {{__('Register')}}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
@endphp
@section('content')
    <div id="app">
        <section class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 pt-4">
                        <div class="changeLanguage float-right mr-1 position-relative">
                            <ul class="navbar-nav navbar-right">
                                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language lang-font"></i></a>
                                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                        <div class="dropdown-header">{{__('Choose Language')}}
                                        </div>

                                        <div class="dropdown-list-content dropdown-list-icons lang-dropdown">
                                            @foreach(Utility::languages() as $language)
                                                <a href="{{ route('register',$language) }}" class="dropdown-item dropdown-item-unread @if($language == $lang) active-language @endif">
                                                    <span> {{Str::upper($language)}}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img class="img-fluid" src="{{$logo.'/logo.png'}}" alt="" width="35%">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header"><h4>{{__('Register')}}</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-lg-6 col-md-6">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6">
                                            <label for="password" class="d-block">{{ __('Password') }}</label>
                                            <input id="password" type="password" data-indicator="pwindicator" class="form-control pwstrength @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6">
                                            <label for="password_confirmation" class="d-block">{{ __('Password Confirmation') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                            <label class="custom-control-label" for="agree">{{__('I agree with the terms and conditions')}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{__('Register')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            {{__(" Don't have an account?")}} <a href="{{ route('login') }}">{{__('Already Have An Accoun')}}t</a>
                        </div>
                        <div class="simple-footer">
                            {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRLab') }} {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
