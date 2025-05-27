@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-6">
            <div class="row gy-3">
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.users.all') }}" icon="las la-users" title="Total Users" value="{{ $widget['total_users'] }}" bg="primary" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.users.active') }}" icon="las la-user-check" title="Active Users" value="{{ $widget['verified_users'] }}" bg="success" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.users.email.unverified') }}" icon="lar la-envelope" title="Email Unverified Users" value="{{ $widget['email_unverified_users'] }}" bg="danger" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.users.mobile.unverified') }}" icon="las la-comment-slash" title="Mobile Unverified Users" value="{{ $widget['mobile_unverified_users'] }}" bg="warning" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.agents.all') }}" icon="las la-users" title="Total Agent" value="{{ $widget['total_agent'] }}" bg="primary" outline="false" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.agents.active') }}" icon="las la-user-check" title="Active Agent" value="{{ $widget['active_agent'] }}" bg="success" outline="false" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.agents.kyc.unverified') }}" icon="lar la-envelope" title="KYC Unverified Agent" value="{{ $widget['kycUnverified'] }}" bg="danger" outline="false" />
                </div>
                <div class="col-sm-6">
                    <x-widget style="6" link="{{ route('admin.agents.kyc.pending') }}" icon="las la-comment-slash" title="KYC Pending Agent" value="{{ $widget['kycPending'] }}" bg="warning" outline="false" />
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="row gy-4">
                <div class="col-sm-6 position-relative">
                    <a class="position-absolute w-100 h-100" href="{{ route('admin.send.money.all') }}"></a>
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--primary">
                            <i class="las la-exchange-alt"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $sendMoney['total'] }}</h2>
                            <p>@lang('Total Send Money')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 position-relative">
                    <a class="position-absolute w-100 h-100" href="{{ route('admin.send.money.pending') }}"></a>
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--warning">
                            <i class="las la-spinner"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $sendMoney['pending'] }}</h2>
                            <p>@lang('Send Money Pending')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 position-relative">
                    <a class="position-absolute w-100 h-100" href="{{ route('admin.send.money.completed') }}"></a>
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--success">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $sendMoney['completed'] }}</h2>
                            <p>@lang('Send Money Completed')</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 position-relative">
                    <a class="position-absolute w-100 h-100" href="{{ route('admin.send.money.refunded') }}"></a>
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--danger">
                            <i class="las la-times"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $sendMoney['refunded'] }}</h2>
                            <p>@lang('Send Money Refunded')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-none-30 mt-30">

        <div class="col-xxl-6 mb-30">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h5 class="card-title">@lang('Monthly Send Money Report') (@lang('Last 12 Month'))</h5>
                        <div class="d-flex flex-wrap justify-content end gap-3 align-items-center">
                            <select name="sending_currency" class="select2 currency-select" data-minimum-results-for-search="-1">
                                <option value="">@lang('Select')</option>
                                @foreach ($sendingCountries as $sendingCountry)
                                    <option value="{{ $sendingCountry->currency }}" @selected($sendingCountry->currency == $selectedSendingCurrency)>{{ $sendingCountry->currency }}
                                    </option>
                                @endforeach
                            </select>
                            <div>@lang('to')</div>
                            <select name="recipient_currency" class="select2 currency-select" data-minimum-results-for-search="-1">
                                <option value="">@lang('Select')</option>
                                @foreach ($receivingCountries as $receivingCountry)
                                    <option value="{{ $receivingCountry->currency }}" @selected($receivingCountry->currency == $selectedReceivingCurrency)>{{ $receivingCountry->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="sendMoneyChart"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 mb-30">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0 py-2">@lang('Country to Country Send Money') (@lang('Last 12 Month'))</h5>
                </div>
                <div class="card-body">
                    @if ($sendMoneyData->count())
                        <div class="table-responsive--sm table-responsive country-to-country-table">
                            <table class="table--light style--two table bg-white">
                                <thead>
                                    <th>@lang('Countries')</th>
                                    <th>@lang('Sent Amount')</th>
                                </thead>
                                <tbody>
                                    @foreach ($sendMoneyData as $transfers)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="user">
                                                        {{ $transfers->sending_country }}
                                                        <span class="thumb ms-2">
                                                            <img src="{{ getImage(getFilePath('country') . '/' . $transfers->sending_country_image, getFileSize('country')) }}" alt="image">
                                                        </span>
                                                    </span>
                                                    <i class="la la-arrow-right"></i>
                                                    <span class="user">
                                                        <span class="thumb me-2">
                                                            <img src="{{ getImage(getFilePath('country') . '/' . $transfers->recipient_country_image, getFileSize('country')) }}" alt="image">
                                                        </span>
                                                        {{ $transfers->recipient_country }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <small>
                                                    <span class="fw-bold">
                                                        {{ showAmount($transfers->total_amount, currencyFormat: false) }}
                                                        {{ $transfers->sending_currency }}
                                                    </span>
                                                    <br>@lang('OR')
                                                    <span class="fw-bold">
                                                        {{ showAmount($transfers->total_base_amount) }}
                                                    </span>
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-notification-list d-flex flex-column h-100 justify-content-center align-items-center">
                            <img src="{{ getImage('assets/images/empty_list.png') }}" alt="empty">
                            <h5 class="text-muted">@lang('No send money data found.')</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card custom--card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Payments')</h5>
                    <div class="widget-card-inner">
                        <div class="widget-card bg--success">
                            <a href="{{ url()->route('admin.payment.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-hand-holding-usd"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($payment['total_payment_amount']) }}</h6>
                                    <p class="widget-card-title">@lang('Total Payment for Send Money')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--warning">
                            <a href="{{ url()->route('admin.payment.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $payment['total_payment_pending'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Payments for Send Money')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--danger">
                            <a href="{{ url()->route('admin.payment.rejected') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $payment['total_payment_rejected'] }}</h6>
                                    <p class="widget-card-title">@lang('Rejected Payments for Send Money')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--dark">
                            <a href="{{ url()->route('admin.payment.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-percentage"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($payment['total_payment_charge']) }}</h6>
                                    <p class="widget-card-title">@lang('Payment Charges for Send Money')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 gy-4">
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title">@lang('Deposits')</h5>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_amount']) }}</h6>
                                    <p class="widget-card-title">@lang('Total Deposited')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.deposit.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_pending'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Deposits')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--danger">
                            <a href="{{ route('admin.deposit.rejected') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_rejected'] }}</h6>
                                    <p class="widget-card-title">@lang('Rejected Deposits')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_charge']) }}</h6>
                                    <p class="widget-card-title">@lang('Deposited Charge')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title">@lang('Withdrawals')</h5>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.withdraw.data.all') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="lar la-credit-card"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($withdrawals['total_withdraw_amount']) }}
                                    </h6>
                                    <p class="widget-card-title">@lang('Total Withdrawn')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.withdraw.data.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $withdrawals['total_withdraw_pending'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Withdrawals')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--danger">
                            <a href="{{ route('admin.withdraw.data.rejected') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-times-circle"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $withdrawals['total_withdraw_rejected'] }}</h6>
                                    <p class="widget-card-title">@lang('Rejected Withdrawals')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.withdraw.data.all') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-percent"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($withdrawals['total_withdraw_charge']) }}
                                    </h6>
                                    <p class="widget-card-title">@lang('Withdrawal Charge')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Monthly Agent\'s Deposit & Withdraw Report')</h5>
                        <div id="dwDatePicker" class="border p-1 cursor-pointer rounded">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>
                    <div id="dwChartArea"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Transactions Report')</h5>
                        <div id="trxDatePicker" class="border p-1 cursor-pointer rounded">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>
                    <div id="transactionChartArea"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.cron_modal')
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#cronModal">
        <i class="las la-server"></i>@lang('Cron Setup')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();
        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }
        let dwChart = barChart(
            document.querySelector("#dwChartArea"),
            @json(__(gs('cur_text'))),
            [{
                    name: 'Deposited',
                    data: []
                },
                {
                    name: 'Withdrawn',
                    data: []
                }
            ],
            [],
        );

        let trxChart = lineChart(
            document.querySelector("#transactionChartArea"),
            [{
                    name: "Plus Transactions",
                    data: []
                },
                {
                    name: "Minus Transactions",
                    data: []
                }
            ],
            []
        );

        const depositWithdrawChart = (startDate, endDate) => {
            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }
            const url = @json(route('admin.chart.deposit.withdraw'));
            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        dwChart.updateSeries(data.data);
                        dwChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        const transactionChart = (startDate, endDate) => {
            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }
            const url = @json(route('admin.chart.transaction'));
            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        $('#dwDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#dwDatePicker span',
            start, end));
        $('#trxDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#trxDatePicker span',
            start, end));

        changeDatePickerText('#dwDatePicker span', start, end);
        changeDatePickerText('#trxDatePicker span', start, end);

        depositWithdrawChart(start, end);
        transactionChart(start, end);

        $('#dwDatePicker').on('apply.daterangepicker', (event, picker) => depositWithdrawChart(picker.startDate, picker
            .endDate));
        $('#trxDatePicker').on('apply.daterangepicker', (event, picker) => transactionChart(picker.startDate, picker
            .endDate));


        let sendMoneyChart = barChart(
            document.querySelector("#sendMoneyChart"),
            @json(__(gs('cur_text'))),
            [{
                name: 'Sending Amount',
                data: []
            }],
            [],
        );

        const sendMoneyGraph = () => {
            var sendingCurrency = $('select[name=sending_currency]').val();
            var recipientCurrency = $('select[name=recipient_currency]').val();

            const data = {
                sending_currency: sendingCurrency,
                recipient_currency: recipientCurrency
            }

            const url = "{{ route('admin.send_money.statistics') }}";

            $.get(url, data,
                function(response, status) {
                    if (status == 'success') {
                        sendMoneyChart.updateSeries(response.data);
                        sendMoneyChart.updateOptions({
                            xaxis: {
                                categories: response.created_on,
                            },
                            yaxis: {
                                title: {
                                    text: sendingCurrency,
                                    style: {
                                        color: '#7c97bb'
                                    }
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val, data) {
                                        if (data.seriesIndex == 0) {
                                            var tooltipText = val + ` ${sendingCurrency}`;
                                            if (response.base_currency_amount[data.dataPointIndex]) {
                                                tooltipText += ` ({{ gs('cur_sym') }}${response.base_currency_amount[data.dataPointIndex] })`;
                                            }
                                            return tooltipText;
                                        } else {
                                            return val + ` ${recipientCurrency}`;
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            );
        }


        sendMoneyGraph();
        $('select[name=sending_currency], select[name=recipient_currency]').on('change', function() {
            sendMoneyGraph();
        });

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chart['user_browser_counter']->keys()),
            @json(@$chart['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chart['user_os_counter']->keys()),
            @json(@$chart['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chart['user_country_counter']->keys()),
            @json(@$chart['user_country_counter']->flatten())
        );
    </script>
@endpush
@push('style')
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 30px;
        }

        .btn-outline--red {
            color: #F44336;
            border-color: #F44336;
        }

        .btn-outline--red:hover {
            background-color: #F44336;
            color: #fff;
        }

        .widget-three__icon {
            width: 80px;
            height: 80px;
        }

        .widget-three__icon i {
            font-size: 32px;
        }

        .widget-three__content {
            margin-top: 15px;
        }

        .country-to-country-table {
            max-height: 400px;
            overflow-x: auto;
        }

        /* width */
        .country-to-country-table::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .country-to-country-table::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .country-to-country-table::-webkit-scrollbar-thumb {
            border-radius: 8px;
            background: #4634ff;
        }

        .select2-container {
            width: 100px !important;
        }
    </style>
@endpush
