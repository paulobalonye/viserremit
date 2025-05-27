@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <h5 class="pb-3 text-center border-bottom">@lang('2FA Verification')</h5>
                        <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form disableSubmission">
                            @csrf
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="form--group">
                                <button type="submit" class="btn btn--base w-100  btn--xl">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
