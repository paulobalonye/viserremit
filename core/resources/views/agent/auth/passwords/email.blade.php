@extends('agent.layouts.master')
@section('content')
    <div class="login-main" style="background-image: url('{{ asset('assets/agent/images/login.jpg') }}')">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8 col-sm-11">
                    <div class="login-area">
                        <div class="login-wrapper">
                            <div class="login-wrapper__top">
                                <h3 class="title text-white">@lang('Recover Agent Account')</h3>
                            </div>
                            <div class="login-wrapper__body">
                                <div class="mb-4 text-white">
                                    <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                                </div>
                                <form action="{{ route('agent.password.reset') }}" method="POST" class="login-form disableSubmission">
                                    @csrf
                                    <div class="form-group">
                                        <label>@lang('Email or Username')</label>
                                        <input type="text" name="value" class="form--control" value="{{ old('value') }}" required>
                                    </div>
                                    <x-captcha />
                                    <button type="submit" class="btn cmn-btn w-100 mb-2">@lang('Submit')</button>
                                    <div class="text-center">
                                        <a href="{{ route('agent.login') }}" class="text-white">
                                            <i class="las la-sign-in-alt" aria-hidden="true"></i>@lang('Back to Login')
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .form--control {
            background-color: transparent !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff !important;
        }

        .btn:hover {
            background-color: #002046 !important;
        }

        .btn-check:checked+.btn,
        .btn.active,
        .btn.show,
        .btn:first-child:active,
        :not(.btn-check)+.btn:active {
            background-color: #002046;
            border-color: #002046 !important;
            color: #fff !important;
        }
    </style>
@endpush
