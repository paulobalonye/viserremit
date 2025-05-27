@extends('agent.layouts.app')
@php
    $kycInstruction = getContent('kyc_instruction_user.content', true);
@endphp
@section('panel')
    <div class="mt-5">
        @if (authAgent()->kv == Status::KYC_UNVERIFIED || authAgent()->kv == Status::KYC_PENDING)
            <div class="mb-30">
                @if (authAgent()->kv == Status::KYC_UNVERIFIED && authAgent()->kyc_rejection_reason)
                    <div class="alert alert--danger" role="alert">
                        <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                        <p class="alert__message m-0">
                            <span class="fw-bold">@lang('KYC Documents Rejected')</span><br>
                            <small>
                                <i>
                                    {{ __(@$kycInstruction->data_values->reject_instruction) }}
                                    <a class="link-color" data-bs-toggle="modal" data-bs-target="#kycRejectionReason"
                                        href="javascript::void(0)">
                                        @lang('Click here')
                                    </a>
                                    @lang('to show the reason').<br>
                                    <a class="link-color" href="{{ route('agent.kyc.form') }}">
                                        @lang('Click Here')
                                    </a>
                                    @lang('to Re-submit Documents').
                                </i>
                            </small>
                        </p>
                    </div>
                @elseif (authAgent()->kv == Status::KYC_UNVERIFIED)
                    <div class="alert alert--info" role="alert">
                        <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                        <p class="alert__message m-0">
                            <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                            <small>
                                <i>
                                    {{ __(@$kycInstruction->data_values->verification_instruction) }}
                                    <a class="link-color" href="{{ route('agent.kyc.form') }}">
                                        @lang('Click here')
                                    </a>
                                </i>
                            </small>
                        </p>
                    </div>
                @elseif(authAgent()->kv == Status::KYC_PENDING)
                    <div class="alert alert--warning" role="alert">
                        <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                        <p class="alert__message m-0">
                            <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                            <small>
                                <i>
                                    {{ __(@$kycInstruction->data_values->pending_instruction) }}
                                    <a class="link-color" href="{{ route('agent.kyc.data') }}">
                                        @lang('Click here')
                                    </a>
                                    @lang('to see your submitted information')
                                </i>
                            </small>
                        </p>
                    </div>
                @endif
            </div>
        @endif
        <div class="row gy-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="d-widget curve--shape">
                    <div class="d-widget__content">
                        <i class="las la-wallet"></i> @lang('USD Balance')
                        <h2 class="d-widget__amount fw-normal">{{ showAmount($widget['balance']) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-widget curve--shape">
                    <div class="d-widget__content">
                        <i class="las la-store"></i> @lang('Pending Deposits')
                        <h2 class="d-widget__amount fw-normal">{{ $widget['pending_deposit'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-widget curve--shape">
                    <div class="d-widget__content">
                        <i class="las la-hand-holding-usd"></i> @lang('Pending Withdrawals')
                        <h2 class="d-widget__amount fw-normal">{{ $widget['pending_withdraw'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-widget curve--shape">
                    <div class="d-widget__content">
                        <i class="la la-exchange-alt"></i> @lang('Total Transactions')
                        <h2 class="d-widget__amount fw-normal">{{ $widget['total_transaction'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 mb-3">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d">
                            <h5 class="card-title">@lang('Monthly  Transaction Report')</h5>
                        </div>
                        <div id="apex-line"> </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <h6 class="fw-normal">@lang('Insights')</h6>
                    </div>
                    <div class="col-6 text-end">
                        <div class="dropdown custom--dropdown has--arrow">
                            <button aria-expanded="false" class="text-btn dropdown-toggle font-size--14px text--base"
                                data-bs-toggle="dropdown" id="latestActivitiesButton" type="button">
                                {{ __($insights['duration']) }}
                            </button>
                            <ul aria-labelledby="latestActivitiesButton" class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item money" href="{{ route('agent.dashboard') }}">
                                        @lang('Today')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item money" href="{{ route('agent.dashboard', 'last-week') }}">
                                        @lang('Last week')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item money" href="{{ route('agent.dashboard', 'last-15-days') }}">
                                        @lang('Last 15 days')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item money" href="{{ route('agent.dashboard', 'last-month') }}">
                                        @lang('Last month')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item money" href="{{ route('agent.dashboard', 'last-year') }}">
                                        @lang('Last year')
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                        <div class="custom--card">
                            <div class="card-body">
                                <h6 class="font-size--16px mb-4">
                                    @lang('Total Payout')
                                    <small class="text--muted last-time">( {{ __($insights['duration']) }} )</small>
                                </h6>
                                <h3 class="title fw-normal money-in">{{ showAmount($insights['payouts']) }}</h3>
                                <span class="text-muted font-size--14px">
                                    @lang('Total amount converted in') {{ gs('cur_text') }}
                                </span>
                                <div class="d-flex align-items-center justify-content-between mt-4 flex-wrap">
                                    <a class="font-size--14px fw-bold" href="{{ route('agent.payout.history') }}">
                                        @lang('View Payouts')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="custom--card">
                            <div class="card-body">
                                <h6 class="font-size--16px mb-4">
                                    @lang('Total Sent Money')
                                    <small class="text--muted last-time">( {{ __($insights['duration']) }} )</small>
                                </h6>
                                <h3 class="title fw-normal money-out">{{ showAmount($insights['sent_amounts']) }}</h3>
                                <span class="text-muted font-size--14px">@lang('Total amount converted in') {{ gs('cur_text') }}</span>
                                <div class="d-flex align-items-center justify-content-between mt-4 flex-wrap">
                                    <a class="font-size--14px fw-bold" href="{{ route('agent.transfer.history') }}">
                                        @lang('View Send Moneys')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="my-2">@lang('Deposits & Withdrawn')</p>
                    <div class="col-sm-6">
                        <div class="custom--card">
                            <div class="card-body">
                                <h6 class="font-size--16px mb-4">
                                    @lang('Total Deposits')
                                    <small class="text--muted last-time">( {{ __($insights['duration']) }} )</small>
                                </h6>
                                <h3 class="title fw-normal">{{ showAmount($insights['deposits']) }}</h3>
                                <div class="d-flex align-items-center justify-content-between mt-4 flex-wrap">
                                    <a class="font-size--14px fw-bold" href="{{ route('agent.deposit.history') }}">
                                        @lang('View Deposits')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="custom--card">
                            <div class="card-body">
                                <h6 class="font-size--16px mb-4">
                                    @lang('Total Withdrawn')
                                    <small class="text--muted last-time">( {{ __($insights['duration']) }} )</small>
                                </h6>
                                <h3 class="title fw-normal">{{ showAmount($insights['withdraws']) }}</h3>
                                <div class="d-flex align-items-center justify-content-between mt-4 flex-wrap">
                                    <a class="font-size--14px fw-bold" href="{{ route('agent.withdraw.history') }}">
                                        @lang('View Withdrawals')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($transactions)
            <div class="accordion table--acordion" id="transactionAccordion">
                <h6 class="p-3">@lang('Latest Transactions')</h6>
                @forelse ($transactions as $transaction)
                    <div
                        class="accordion-item transaction-item {{ $transaction->trx_type == '-' ? 'sent-item' : 'rcv-item' }}">
                        <h2 class="accordion-header" id="h-{{ $loop->iteration }}">
                            <button aria-controls="c-1" aria-expanded="false" class="accordion-button collapsed"
                                data-bs-target="#c-{{ $loop->iteration }}" data-bs-toggle="collapse" type="button">
                                <div class="col-lg-3 col-sm-4 col-6 icon-wrapper order-1">
                                    <div class="left">
                                        <div class="icon">
                                            <i class="las la-long-arrow-alt-right"></i>
                                        </div>
                                        <div class="content">
                                            <h6 class="trans-title">{{ __(keyToTitle($transaction->remark)) }}</h6>
                                            <span class="text-muted font-size--14px mt-2">
                                                {{ showDateTime($transaction->created_at, 'M d Y @g:ia') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-5 col-12 order-sm-2 content-wrapper mt-sm-0 order-3 mt-3">
                                    <p class="text-muted font-size--14px"><b>{{ __($transaction->details) }}</b></p>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-6 order-sm-3 text-end amount-wrapper order-2">
                                    <p><b>{{ showAmount($transaction->amount) }}</b></p>
                                </div>
                            </button>
                        </h2>
                        <div aria-labelledby="h-1" class="accordion-collapse collapse"
                            data-bs-parent="#transactionAccordion" id="c-{{ $loop->iteration }}">
                            <div class="accordion-body">
                                <ul class="caption-list">
                                    <li>
                                        <span class="caption">@lang('Transaction ID')</span>
                                        <span class="value">{{ $transaction->trx }}</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Transacted Amount')</span>
                                        <span class="value"> {{ $transaction->trx_type }}
                                            {{ showAmount($transaction->amount) }}</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Remaining Balance')</span>
                                        <span class="value">{{ showAmount($transaction->post_balance) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="accordion-body text-center">
                        <h4 class="text--muted">@lang('No transaction found')</h4>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
    @if (authAgent()->kv == Status::KYC_UNVERIFIED && authAgent()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-0">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="py-2">{{ authAgent()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('/assets/global/js/apexcharts.min.js') }}"></script>
    <script>
        'use strict';
        (function($) {
            $('.reason').on('click', function() {
                $('#reasonModal').find('.reason').text($(this).data('reasons'))
                $('#reasonModal').modal('show')
            });
        })(jQuery);

        var options = {
            chart: {
                height: 376,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                    name: "Plus Transactions",
                    data: [
                        @foreach ($trxReport['date'] as $trxDate)
                            {{ getAmount(@$plusTrx->where('date', $trxDate)->first()->amount ?? 0) }},
                        @endforeach
                    ]
                },
                {
                    name: "Minus Transactions",
                    data: [
                        @foreach ($trxReport['date'] as $trxDate)
                            {{ getAmount(@$minusTrx->where('date', $trxDate)->first()->amount ?? 0) }},
                        @endforeach
                    ]
                }
            ],

            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ __(gs('cur_sym')) }}" + val + " "
                    }
                }
            },
            xaxis: {
                categories: [
                    @foreach ($trxReport['date'] as $trxDate)
                        "{{ $trxDate }}",
                    @endforeach
                ]
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {

                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);
        chart.render()
    </script>
@endpush
