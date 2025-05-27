@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="section section--xl">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-12">
                    <div class="show-filter text-end mb-3">
                        <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                            @lang('Filter')</button>
                    </div>
                    <div class="card custom--card responsive-filter-card mb-4">
                        <div class="card-body">
                            <form>
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1">
                                        <label>@lang('Transaction Number')</label>
                                        <input type="text" name="search" value="{{ request()->search }}"
                                            class="form-control form--control">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="form-group select2-parent">
                                            <label>@lang('Type')</label>
                                            <select name="trx_type" class="form-select form--select select2-basic"
                                                data-minimum-results-for-search="-1">
                                                <option value="">@lang('All')</option>
                                                <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')
                                                </option>
                                                <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="form-group">
                                            <label>@lang('Remark')</label>
                                            <select class="form-select form--select select2-basic"
                                                data-minimum-results-for-search="-1" name="remark">
                                                <option value="">@lang('Any')</option>
                                                @foreach ($remarks as $remark)
                                                    <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                                        {{ __(keyToTitle($remark->remark)) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--xl btn--base w-100">
                                            <i class="las la-filter"></i>
                                            @lang('Filter')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive--md">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th>@lang('Trx Number')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->trx }}
                                        </td>
                                        <td>
                                            @if ($transaction->trx_type == '+')
                                                <div class="badge badge--success">
                                                    +{{ showAmount($transaction->amount) }}
                                                </div>
                                            @else
                                                <div class="badge badge--danger">
                                                    -{{ showAmount($transaction->amount) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ showAmount($transaction->charge) }}</td>
                                        <td>{{ showAmount($transaction->post_balance) }}</td>
                                        <td>{{ showDateTime($transaction->created_at) }}</td>
                                        <td>{{ $transaction->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($transactions->hasPages())
                <div class="mt-4 paginate">
                    {{ paginateLinks($transactions) }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .paginate p {
            margin: 0px !important;
        }
    </style>
@endpush
