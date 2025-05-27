@extends($activeTemplate . 'layouts.frontend')
@php
    $registerContent = getContent('register.content', true);
@endphp
@section('content')
    <div class="section login-section"
        style="background-image: url({{ getImage($activeTemplateTrue . 'images/auth-bg.jpg') }})">
        <div class="container">
            <div class="row g-4 g-xl-0 justify-content-between align-items-center">
                <div class="col-lg-4 col-xl-6 d-none d-lg-block">
                    <img class="img-fluid"
                        src="{{ frontendImage('register', @$registerContent->data_values->image, '660x625') }}"
                        alt="register image">
                </div>
                <div class="col-lg-8 col-xl-6">
                    <div class="login__right bg--light">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link {{ request()->type != 'business' ? 'active' : '' }}"
                                    href="{{ route('user.register') }}">
                                    @lang('Personal')
                                </a>
                                <a class="nav-link {{ request()->type == 'business' ? 'active' : '' }}"
                                    href="{{ route('user.register') }}?type=business">
                                    @lang('Business')
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content mt-4" id="nav-tabContent">
                            <form class="login__form row g-3 g-sm-4 verify-gcaptcha disableSubmission"
                                action="{{ route('user.register') }}" autocomplete="off" method="POST">
                                @csrf
                                <input name="type" type="hidden" value="1">
                                <div class="col-sm-6 col-xl-6 ">
                                    <div class="form-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md"
                                            for="company_name">@lang('Company Name')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="la la-home"></i>
                                            </span>
                                            <input class="form-control form--control " name="company_name" type="text"
                                                value="{{ old('company_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-6 ">
                                    <div class="forn-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md"
                                            for="owner_name">@lang('Owner Name')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="la la-user-tie"></i>
                                            </span>
                                            <input class="form-control form--control " name="owner_name" type="text"
                                                value="{{ old('owner_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label sm-text t-heading-font heading-clr fw-md">@lang('First Name')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="las la-user"></i>
                                            </span>
                                            <input type="text" class="form-control form--control" name="firstname"
                                                value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Last Name')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="las la-user-circle"></i>
                                            </span>
                                            <input type="text" class="form-control form--control" name="lastname"
                                                value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md"
                                            for="business_email">@lang('Email')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="las la-envelope"></i>
                                            </span>
                                            <input class="form-control checkBusinessUser form--control" id="business_email"
                                                name="email" type="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-6 ">
                                    <div class="form-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md"
                                            for="business_password">@lang('Password')</label>
                                        <div class="input-group hover-input-popup ">
                                            <span class="input-group-text">
                                                <i class="las la-lock"></i>
                                            </span>
                                            <input
                                                class="form-control form--control border-end-0 @if (gs('secure_password')) secure-password @endif"
                                                id="business_password" name="password" type="password" />
                                            <span class="input-group-text pass-toggle border-start-0">
                                                <i class="las la-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-6 ">
                                    <div class="form-group">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md"
                                            for="business_confirm_password">@lang('Confirm Password')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="las la-lock"></i>
                                            </span>
                                            <input autocomplete="new-password"
                                                class="form-control form--control border-end-0""
                                                name="password_confirmation" required type="password"
                                                id="business_confirm_password" />
                                            <span class="input-group-text pass-toggle border-start-0">
                                                <i class="las la-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <x-captcha class="sm-text t-heading-font heading-clr fw-md"/>
                                @if (gs('agree'))
                                    @php
                                        $policyPages = getContent('policy_pages.element', false, null, true);
                                    @endphp
                                    <div class="form-group">
                                        <input id="agree1" name="agree" type="checkbox" @checked(old('agree'))
                                            required>
                                        <label for="agree1" class="d-inline">@lang('I agree with')
                                            <span>
                                                @foreach ($policyPages as $policy)
                                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                                        target="_blank">{{ __($policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <button class="btn btn--xl btn--base w-100 btn--xl"> @lang('Submit') </button>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="d-inline-block">
                                            @lang('Have an account?')
                                        </span>
                                        <a href="{{ route('user.login') }}"
                                            class="t-link d-inline-block text-end t-link--base base-clr sm-text lh-1 text-center"> @lang('Login')
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="existModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pt-0">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn-sm" data-bs-dismiss="modal"
                        type="button">@lang('Close')</button>
                    <a class="btn btn--base btn-sm" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .nav-link {
            width: 50%;
            text-align: center;
        }

        .nav {
            justify-content: space-between;
        }
    </style>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
