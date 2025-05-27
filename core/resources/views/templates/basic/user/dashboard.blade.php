@extends($activeTemplate . 'layouts.master')
@php
    $kycInstruction = getContent('kyc_instruction_user.content', true);
@endphp
@section('content')
    <div class="section section--xl">
        <div class="section__head p-2">
            <div class="container">
                <div class="notice"></div>
            </div>
        </div>
        @if (auth()->user()->kv != 1)
            <div class="section__head p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                                <div class="alert alert--danger" role="alert">
                                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                                    <p class="alert__message m-0">
                                        <span class="fw-bold">@lang('KYC Documents Rejected')</span><br>
                                        <small>
                                            <i>
                                                {{ __(@$kycInstruction->data_values->reject_instruction) }}
                                                <a class="link-color" data-bs-toggle="modal"
                                                    data-bs-target="#kycRejectionReason" href="javascript::void(0)">
                                                    @lang('Click here')
                                                </a>
                                                @lang('to show the reason').
                                                <a class="link-color" href="{{ route('user.kyc.form') }}">
                                                    @lang('Click Here')
                                                </a>
                                                @lang('to Re-submit Documents').
                                                <a class="link-color" href="{{ route('user.kyc.data') }}">
                                                    @lang('See KYC Data')
                                                </a>
                                            </i>
                                        </small>
                                    </p>
                                </div>
                            @elseif (auth()->user()->kv == Status::KYC_UNVERIFIED)
                                <div class="alert alert--info" role="alert">
                                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                                    <p class="alert__message m-0">
                                        <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                                        <small>
                                            <i>
                                                {{ __(@$kycInstruction->data_values->verification_instruction) }}
                                                <a class="link-color" href="{{ route('user.kyc.form') }}">
                                                    @lang('Click here')
                                                </a>
                                            </i>
                                        </small>
                                    </p>
                                </div>
                            @elseif(auth()->user()->kv == Status::KYC_PENDING)
                                <div class="alert alert--warning" role="alert">
                                    <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                                    <p class="alert__message m-0">
                                        <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                                        <small>
                                            <i>
                                                {{ __(@$kycInstruction->data_values->pending_instruction) }}
                                                <a class="link-color" href="{{ route('user.kyc.data') }}">
                                                    @lang('Click here')
                                                </a>
                                                @lang('to see your submitted information')
                                            </i>
                                        </small>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="section__head">
            <div class="container">
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Refunded Wallet Balance')</p>
                                <div class="text mt-2 mb-0">
                                    {{ showAmount($widget['balance']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Send Money Completed')</p>
                                <div class="text  mt-2 mb-0">
                                    {{ showAmount($widget['send_money_amount']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Send Money Pending')</p>
                                <div class="text  mt-2 mb-0">
                                    {{ showAmount($widget['send_money_pending']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Send Money Initiated')</p>
                                <div class="text">
                                    {{ showAmount($widget['send_money_initiated']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Pending Payment')</p>
                                <div class="text">
                                    {{ showAmount($widget['payment_pending']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-card flex-grow-1">
                        <div class="user align-items-center justify-content-center">
                            <div class="icon icon--lg icon--circle">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="user__content">
                                <p class="xl-text mb-0">@lang('Rejected Payment')</p>
                                <div class="text">
                                    {{ showAmount($widget['payment_rejected']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row g-lg-3">
                <div class="col-12">
                    <div class="custom--table__header">
                        <h5 class="text-lg-start m-0 text-center">@lang('Recent Send Money Log')</h5>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive--md">
                        @include($activeTemplate . 'partials.send_money_table', [
                            'transfers' => $transfers,
                            'hasBtn' => false,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-0">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- feedback MODAL --}}
    <div class="modal custom--modal fade" id="feedbackModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Feedback')</h5>
                    <button aria-label="Close" class="close btn btn--danger btn-sm close-button" data-bs-dismiss="modal"
                        type="button">
                        <i aria-hidden="true" class="la la-times"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <span class="admin_feedback"></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.feedbackBtn').on('click', function() {
                var modal = $('#feedbackModal');
                modal.find('.admin_feedback').text($(this).data('admin_feedback'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('style-lib')
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600&display=swap" rel="stylesheet">
@endpush

@push('style')
    <style>
        .dashboard-card .user__content h4 {
            font-family: "rajdhani", sans-serif;
            font-weight: 500;
        }
    </style>
@endpush
