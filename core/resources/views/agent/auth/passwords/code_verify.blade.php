@extends('agent.layouts.master')
@section('content')
    <div class="login-main" style="background-image: url('{{ asset('assets/agent/images/login.jpg') }}')">
        <div class="container custom-container d-flex justify-content-center">
            <div class="login-area">
                <div class="text-center mb-3">
                    <h2 class="text-white mb-2">@lang('Verify Code')</h2>
                    <p class="text-white">@lang('A 6 digit verification code sent to your email address') :  {{ showEmailAddress($email) }}</p>
                </div>
                <form action="{{ route('agent.password.verify.code') }}" method="POST" class="login-form w-100 disableSubmission">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="code-box-wrapper d-flex w-100">
                        <div class="form-group mb-3 flex-fill">
                            <span class="text-white fw-bold">@lang('Verification Code')</span>
                            <div class="verification-code">
                                <input type="text" name="code" class="overflow-hidden" autocomplete="off">
                                <div class="boxes">
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                    <span>-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between">
                        <a href="{{ route('agent.password.reset') }}" class="forget-text">@lang('Try to send again')</a>
                    </div>
                    <button type="submit" class="btn cmn-btn w-100 mt-4">@lang('Submit')</button>
                </form>
                <a href="{{ route('agent.login') }}" class="text-white mt-3">
                    <i class="las la-sign-in-alt" aria-hidden="true"></i>@lang('Back to Login')
                </a>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/agent/css/code_verification.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('[name=code]').on('input', function() {

                $(this).val(function(i, val) {
                    if (val.length >= 6) {
                        $('form').find('button[type=submit]').html('<i class="las la-spinner fa-spin"></i>');
                        $('form').find('button[type=submit]').removeClass('disabled');
                        $('form')[0].submit();
                    } else {
                        $('form').find('button[type=submit]').addClass('disabled');
                    }
                    if (val.length > 6) {
                        return val.substring(0, val.length - 1);
                    }
                    return val;
                });

                for (let index = $(this).val().length; index >= 0; index--) {
                    $($('.boxes span')[index]).html('');
                }
            });

        })(jQuery)
    </script>
@endpush
