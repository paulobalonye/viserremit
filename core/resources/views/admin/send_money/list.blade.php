@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('MTCN')</th>
                                    <th>@lang('Created By')</th>
                                    <th>@lang('Sender')</th>
                                    <th>@lang('Recipient')</th>
                                    <th>@lang('Delivery Method')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sendMoneys as $sendMoney)
                                    <tr>
                                        <td>
                                            <span class="text--muted fw-bold">#{{ @$sendMoney->mtcn_number }}</span>
                                            <br>
                                            <em
                                                class="text--muted text--small">{{ showDateTime(@$sendMoney->created_at) }}</em>
                                        </td>
                                        <td>
                                            @if ($sendMoney->user_id)
                                                <span class="fw-bold">{{ @$sendMoney->user->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $sendMoney->user_id) }}"><span>@</span>{{ @$sendMoney->user->username }}</a>
                                                </span>
                                            @else
                                                <span class="fw-bold">{{ @$sendMoney->agent->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ route('admin.agents.detail', $sendMoney->agent_id) }}">
                                                        <span>@</span>{{ @$sendMoney->agent->username }}
                                                    </a>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ @$sendMoney->senderInfo->name }}
                                            <br>
                                            <a href="{{ route('admin.country.index') }}?search={{ @$sendMoney->sendingCountry->name }}"
                                                class="fw-bold">
                                                {{ __(@$sendMoney->sendingCountry->name) }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $sendMoney->recipient->name }}<br>
                                            <a href="{{ route('admin.country.index') }}?search={{ @$sendMoney->recipientCountry->name }}"
                                                class="fw-bold">
                                                {{ __($sendMoney->recipientCountry->name) }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($sendMoney->country_delivery_method_id)
                                                <span
                                                    class="fw-bold text--danger">{{ __(@$sendMoney->countryDeliveryMethod->deliveryMethod->name) }}</span>
                                            @else
                                                <span class="text--info fw-bold">@lang('Agent')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span>{{ showAmount($sendMoney->sending_amount, currencyFormat: false) }}
                                                {{ @$sendMoney->sending_currency }}</span>
                                            <i class="la la-arrow-right"></i>
                                            <span>{{ showAmount($sendMoney->recipient_amount, currencyFormat: false) }}
                                                {{ __($sendMoney->recipient_currency) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                echo $sendMoney->statusBadge;
                                            @endphp
                                            <br>
                                            {{ diffForHumans($sendMoney->updated_at) }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary"
                                                href="{{ route('admin.send.money.details', $sendMoney->id) }}">
                                                <i class="las la-desktop"></i>@lang('Details')
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
                @if ($sendMoneys->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($sendMoneys) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- filter --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filter" aria-labelledby="filterLabel">
        <div class="offcanvas-header">
            <h5 class="ms-3">@lang('Filter')</h5>
            <button type="button" class="btn-close text-reset me-2 " data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('User Username') </label>
                        <input class="form-control" name="user" type="text" value="{{ request()->user ?? '' }}" />
                    </div>
                    <div class="form-group">
                        <label>@lang('Agent Username') </label>
                        <input class="form-control" name="agent" type="text" value="{{ request()->agent ?? '' }}" />
                    </div>
                    <div class="form-group">
                        <label>@lang('Recipient Name') </label>
                        <input class="form-control" name="recipient" type="text"
                            value="{{ request()->recipient ?? '' }}" />
                    </div>
                    <div class="form-group">
                        <label>@lang('MTCN Number') </label>
                        <input class="form-control" name="mtcn_number" type="text"
                            value="{{ request()->mtcn_number ?? '' }}" />
                    </div>
                    <div class="form-group">
                        <label>@lang('Amount') </label>
                        <input class="form-control" name="sending_amount" type="text"
                            value="{{ request()->sending_amount ?? '' }}" />
                    </div>
                    <div class="flex-grow-1">
                        <label>@lang('Date')</label>
                        <input name="date" type="search" class="datepicker-here form-control bg--white pe-2 date-range"
                            placeholder="@lang('Start Date - End Date')" autocomplete="off" value="{{ request()->date }}">
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .datepickers-container {
            z-index: 9999;
        }
    </style>
@endpush

@push('breadcrumb-plugins')
    <x-search-form placeholder="MTCN/Sender/Recipient" />

    <button class="btn btn--primary h-45" data-bs-toggle="offcanvas" href="#filter" role="button" aria-controls="filter">
        <i class="fas fa-filter"></i> @lang('Filter')</button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"

            const datePicker = $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showDropdowns: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                },
                maxDate: moment()
            });
            const changeDatePickerText = (event, startDate, endDate) => {
                $(event.target).val(startDate.format('MMMM DD, YYYY') + ' - ' + endDate.format('MMMM DD, YYYY'));
            }


            $('.date-range').on('apply.daterangepicker', (event, picker) => changeDatePickerText(event, picker
                .startDate, picker.endDate));


            if ($('.date-range').val()) {
                let dateRange = $('.date-range').val().split(' - ');
                $('.date-range').data('daterangepicker').setStartDate(new Date(dateRange[0]));
                $('.date-range').data('daterangepicker').setEndDate(new Date(dateRange[1]));
            }

        })(jQuery)
    </script>
@endpush
