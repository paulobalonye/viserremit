@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.update') }}" class="disableSubmission">
                                @csrf
                                <input name="email" type="hidden" value="{{ $email }}">
                                <input name="token" type="hidden" value="{{ $token }}">
                                <div class="mt-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Password')
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control form--control" name="password" type="password" required>
                                        <span class="input-group-text pass-toggle border-start-0">
                                            <i class="las la-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                        @lang('Confirm Password')
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password_confirmation" type="password" autocomplete="false" required>
                                        <span class="input-group-text pass-toggle border-start-0">
                                            <i class="las la-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn--base w-100 btn--xl" type="submit"> @lang('Submit')</button>
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
