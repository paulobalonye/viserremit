<table class="custom--table table">
    <thead>
        <tr>
            <th>@lang('MTCN')</th>
            <th>@lang('Amount')</th>
            <th>@lang('Recipient')</th>
            <th>@lang('Send') | @lang('Received')</th>
            <th>@lang('Payment')</th>
            <th>@lang('Status')</th>
            @if ($hasBtn)
                <th>@lang('Action')</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse ($transfers as $transfer)
            <tr>
                <td> #<span class="fw-bold">{{ $transfer->mtcn_number }}</span></td>
                <td>
                    <div>
                        <span class="fw-md">
                            {{ showAmount($transfer->sending_amount, currencyFormat: false) }}
                            {{ __($transfer->sending_currency) }}
                        </span>
                        <i class="la la-arrow-right"></i>
                        <span class="fw-md">
                            {{ showAmount($transfer->recipient_amount, currencyFormat: false) }}
                            {{ __($transfer->recipient_currency) }}
                        </span>
                    </div>
                    <span class="text--danger">
                        @lang('Charge'): {{ showAmount($transfer->sending_charge, currencyFormat: false) }}
                        {{ __($transfer->sending_currency) }}
                    </span>
                </td>
                <td>
                    <span class="fw-bold text--primary">{{ $transfer->recipient->name }}</span>
                    <br>
                    <span class="text-muted">
                        <i class="la la-globe"></i>
                        {{ __(@$transfer->recipientCountry->name) }}
                    </span>
                </td>
                <td>
                    <em>{{ showDateTime($transfer->created_at, 'd M, y h:i a') }}</em>
                    <br />
                    <em>{{ $transfer->received_at ? showDateTime($transfer->received_at, 'd M, y h:i a') : 'N/A' }}</em>
                </td>
                <td>
                    <span>{{ showAmount($transfer->paidAmount()) }}</span>
                    <br>
                    @php echo $transfer->paymentStatusBadge; @endphp
                    @if ($transfer->payment_status == Status::PAYMENT_REJECT && $transfer->admin_feedback != null)
                        <button class="btn-info rounded badge feedbackBtn"
                            data-admin_feedback="{{ $transfer->admin_feedback }}">
                            <i class="fa fa-info"></i>
                        </button>
                    @endif
                </td>
                <td>
                    @if ($transfer->status == Status::SEND_MONEY_REFUNDED && $transfer->admin_feedback != null)
                        <button class="btn-info rounded badge feedbackBtn"
                            data-admin_feedback="{{ $transfer->admin_feedback }}">
                            <i class="fa fa-info"></i>
                        </button>
                    @endif
                    @php echo $transfer->statusBadge;@endphp
                </td>
                @php
                    $details = $transfer->detail != null ? json_encode($transfer->detail) : null;
                @endphp
                @if ($hasBtn)
                    <td>
                        <button class="btn btn--base btn-sm detailBtn"
                            data-address="{{ $transfer->recipient->address }}"
                            data-country="{{ @$transfer->recipientCountry->name }}"
                            data-id="{{ encrypt($transfer->id) }}" data-info="{{ $details }}"
                            data-mobile="{{ $transfer->recipient->mobile }}"
                            data-name="{{ $transfer->recipient->name }}"
                            data-payment_status="{{ $transfer->payment_status }}"
                            data-payment_via="{{ $transfer->deposit ? @$transfer->deposit->gateway->name : __('Refunded Wallet') }}"
                            data-recipient_amount="{{ showAmount($transfer->recipient_amount, currencyFormat: false) }} {{ __($transfer->recipient_currency) }}"
                            data-send_money_amount="{{ $transfer->sending_amount }}"
                            data-sending_currency="{{ __($transfer->sending_currency) }}"
                            data-send_amount_in_base_currency="{{ showAmount($transfer->base_currency_amount + $transfer->base_currency_charge, currencyFormat: false) }}"
                            data-total_payable_amount="{{ showAmount($transfer->paidAmount(), currencyFormat: false) }}"
                            data-deposit="{{ $transfer->deposit }}"
                            data-delivery_charge="{{ showAmount($transfer->sending_charge, currencyFormat: false) }}"
                            data-including_charge="{{ showAmount($transfer->sending_amount + $transfer->sending_charge, currencyFormat: false) }}"
                            data-status="{{ $transfer->status }}" data-mtcn_number="{{ $transfer->mtcn_number }}"
                            data-trx="{{ $transfer->trx }}"
                            data-conversion_rate="{{ showAmount($transfer->conversion_rate, decimal: 8, exceptZeros: true, currencyFormat: false) }}"
                            data-base_currency_rate="{{ showAmount($transfer->base_currency_rate, decimal: 8, exceptZeros: true, currencyFormat: false) }}"
                            data-recipient_currency="{{ $transfer->recipient_currency }}"
                            data-delivery_method="{{ $transfer->country_delivery_method_id ? __($transfer->countryDeliveryMethod->deliveryMethod->name) : __('Agent') }}"
                            data-sent_at="{{ showDateTime($transfer->created_at) }}">
                            <i class="la la-desktop"></i>
                        </button>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
