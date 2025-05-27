@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form class="verify-gcaptcha disableSubmission" method="POST"
                                action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Email or Username')
                                    </label>
                                    <input type="text" class="form-control form--control" name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                </div>
                                <x-captcha class="sm-text t-heading-font heading-clr fw-md" />
                                <div class="mt-3">
                                    <button class="btn btn--base w-100 btn--xl" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
