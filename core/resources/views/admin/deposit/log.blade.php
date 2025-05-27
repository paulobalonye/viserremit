@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs("admin.$type.list") || request()->routeIs("admin.$type.method"))
            <div class="col-12">
                @include('admin.deposit.widget')
            </div>
        @endif

        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway | Transaction')</th>
                                    <th>@lang('Initiated')</th>
                                    @if ($type == 'payment')
                                        <th>@lang('MTCN Number')</th>
                                        <th>@lang('User')</th>
                                    @else
                                        <th>@lang('Agent')</th>
                                    @endif
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                    @php
                                        $details = $deposit->detail ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-bold">
                                                <a
                                                    href="{{ appendQuery('method', $deposit->method_code < 5000 ? @$deposit->gateway->alias : $deposit->method_code) }}">
                                                    @if ($deposit->method_code < 5000)
                                                        {{ __(@$deposit->gateway->name) }}
                                                    @else
                                                        @lang('Google Pay')
                                                    @endif
                                                </a>
                                            </span>
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </td>
                                        <td>
                                            {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </td>
                                        @if ($type == 'payment')
                                            <td>
                                                @if (
                                                    @$deposit->sendMoney->status == Status::SEND_MONEY_PENDING ||
                                                        (@$deposit->sendMoney->status == Status::SEND_MONEY_COMPLETED && $deposit->status != Status::PAYMENT_REJECT))
                                                    <a href="{{ route('admin.send.money.all') }}?search={{ @$deposit->sendMoney->mtcn_number }}">
                                                        {{ @$deposit->sendMoney->mtcn_number }}
                                                    </a>
                                                @else
                                                    <span class="fw-bold">@lang('Not Available')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ @$deposit->user->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ appendQuery('search', @$deposit->user->username) }}">
                                                        <span>@</span>{{ @$deposit->user->username }}
                                                    </a>
                                                </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="fw-bold">{{ @$deposit->agent->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ appendQuery('search', @$deposit->agent->username) }}">
                                                        <span>@</span>{{ @$deposit->agent->username }}
                                                    </a>
                                                </span>
                                            </td>
                                        @endif
                                        <td>
                                            {{ showAmount($deposit->amount) }} + <span class="text--danger"
                                                title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                            </strong>
                                        </td>
                                        <td>
                                            {{ showAmount(1) }} = {{ showAmount($deposit->rate, currencyFormat: false) }}
                                            {{ __($deposit->method_currency) }}
                                            <br>
                                            <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }}
                                                {{ __($deposit->method_currency) }}</strong>
                                        </td>
                                        <td>
                                            @php echo $deposit->statusBadge @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route("admin.$type.details", $deposit->id) }}"
                                                class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($deposits->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($deposits) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' placeholder='Username / TRX' />
@endpush
