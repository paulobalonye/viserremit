@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="section section--xl">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __($pageTitle) }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Current Password')
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control form--control" name="current_password" type="password"
                                            required autocomplete="current-password">
                                        <span class="input-group-text pass-toggle border-start-0">
                                            <i class="las la-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Password')
                                    </label>
                                    <div class="input-group">
                                        <input
                                            class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                            name="password" type="password" required autocomplete="current-password">
                                        <span class="input-group-text pass-toggle border-start-0">
                                            <i class="las la-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Confirm Password')
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control form--control" name="password_confirmation" type="password"
                                            required autocomplete="current-password">
                                        <span class="input-group-text pass-toggle border-start-0">
                                            <i class="las la-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
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

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
