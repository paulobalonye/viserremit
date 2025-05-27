@extends('admin.layouts.app')
@section('panel')
    <form method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12 col-md-12 mb-30">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Site Title')</label>
                                    <input class="form-control" type="text" name="site_name" required value="{{ gs('site_name') }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency')</label>
                                    <input class="form-control" type="text" name="cur_text" required value="{{ gs('cur_text') }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency Symbol')</label>
                                    <input class="form-control" type="text" name="cur_sym" required value="{{ gs('cur_sym') }}">
                                </div>
                            </div>
                            <div class="form-group col-xl-3 col-sm-6">
                                <label class="required"> @lang('Timezone')</label>
                                <select class="select2 form-control" name="timezone">
                                    @foreach ($timezones as $key => $timezone)
                                        <option value="{{ @$key }}" @selected(@$key == $currentTimezone)>{{ __($timezone) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl-4 col-sm-6">
                                <label class="required"> @lang('Site Base Color')</label>
                                <div class="input-group">
                                    <span class="input-group-text p-0 border-0">
                                        <input type='text' class="form-control colorPicker" value="{{ gs('base_color') }}">
                                    </span>
                                    <input type="text" class="form-control colorCode" name="base_color" value="{{ gs('base_color') }}">
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-sm-6">
                                <label> @lang('Record to Display Per page')</label>
                                <select class="select2 form-control" name="paginate_number" data-minimum-results-for-search="-1">
                                    <option value="20" @selected(gs('paginate_number') == 20)>@lang('20 items per page')</option>
                                    <option value="50" @selected(gs('paginate_number') == 50)>@lang('50 items per page')</option>
                                    <option value="100" @selected(gs('paginate_number') == 100)>@lang('100 items per page')</option>
                                </select>
                            </div>
                            <div class="form-group col-xl-4 col-sm-6 ">
                                <label class="required"> @lang('Currency Showing Format')</label>
                                <select class="select2 form-control" name="currency_format" data-minimum-results-for-search="-1">
                                    <option value="1" @selected(gs('currency_format') == Status::CUR_BOTH)>@lang('Show Currency Text and Symbol Both')</option>
                                    <option value="2" @selected(gs('currency_format') == Status::CUR_TEXT)>@lang('Show Currency Text Only')</option>
                                    <option value="3" @selected(gs('currency_format') == Status::CUR_SYM)>@lang('Show Currency Symbol Only')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 mb-30">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('User Send Money Setting')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Limit Per Send Money') <i class="fas fa-info-circle text--primary" title="@lang('The amount user can send in each send money transaction.')"></i></label>
                                    <div class="input-group">
                                        <input class="form-control" name="user_send_money_limit" type="number" value="{{ getAmount(gs('user_send_money_limit')) }}" min="0" step="any">
                                        <span class="input-group-text">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Daily Send Money Limit') <i class="fas fa-info-circle text--primary" title="@lang('The amount user can send on a calender date.')"></i></label>
                                    <div class="input-group">
                                        <input class="form-control" name="user_daily_send_money_limit" type="number" value="{{ getAmount(gs('user_daily_send_money_limit')) }}" min="0" step="any">
                                        <span class="input-group-text">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Monthly Send Money Limit') <i class="fas fa-info-circle text--primary" title="@lang('The amount user can send on a calender month.')"></i></label>
                                    <div class="input-group">
                                        <input class="form-control" name="user_monthly_send_money_limit" type="number" value="{{ getAmount(gs('user_monthly_send_money_limit')) }}" min="0" step="any">
                                        <span class="input-group-text">{{ gs('cur_text') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (gs('agent_module'))
                <div class="col-12 mb-30">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Agent Setting')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            @lang('Limit Per Send Money')
                                            <i class="fas fa-info-circle text--primary" title="@lang('The amount agent can send in each send money transaction.')"></i>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_send_money_limit" type="number" value="{{ getAmount(gs('agent_send_money_limit')) }}" min="0" step="any">
                                            <span class="input-group-text">{{ gs('cur_text') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            @lang('Daily Send Money Limit')
                                            <i class="fas fa-info-circle text--primary" title="@lang('The amount agent can send on a calender date.')"></i>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_daily_send_money_limit" type="number" value="{{ getAmount(gs('agent_daily_send_money_limit')) }}" min="0" step="any">
                                            <span class="input-group-text">{{ gs('cur_text') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            @lang('Monthly Send Money Limit')
                                            <i class="fas fa-info-circle text--primary" title="@lang('The amount agent can send on a calender month.')"></i>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_monthly_send_money_limit" type="number" value="{{ getAmount(gs('agent_monthly_send_money_limit')) }}" min="0" step="any">
                                            <span class="input-group-text">{{ gs('cur_text') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            @lang('Fixed Charge')
                                            <i class="fas fa-info-circle text--primary" title="@lang('The charge will be applied when the user sends money via an agent.')"></i>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_charges[fixed_charge]" type="number" value="{{ getAmount(gs('agent_charges')->fixed_charge) }}" min="0" step="any">
                                            <div class="input-group-text cur_text">
                                                {{ gs('cur_text') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            @lang('Percent Charge')
                                            <i class="fas fa-info-circle text--primary" title="@lang('The charge will be applied when the user sends money via an agent.')"></i>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_charges[percent_charge]" type="number" value="{{ getAmount(gs('agent_charges')->percent_charge) }}" min="0" step="any">
                                            <div class="input-group-text cur_text">%</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('OTP Validity') </label>
                                        <div class="input-group">
                                            <input class="form-control" name="resent_code_duration" type="text" value="{{ gs('resent_code_duration') }}">
                                            <span class="input-group-text">
                                                @lang('Seconds')
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label> @lang('Fixed Commission')</label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_fixed_commission" type="number" value="{{ getAmount(gs('agent_fixed_commission')) }}" min="0" step="any">
                                            <div class="input-group-text cur_text">
                                                {{ gs('cur_text') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Percent Commission') </label>
                                        <div class="input-group">
                                            <input class="form-control" name="agent_percent_commission" type="number" value="{{ getAmount(gs('agent_percent_commission')) }}" min="0" step="any">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 mb-30">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Referral Setting')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Referral Commission')</label>
                                    <div class="input-group">
                                        <input class="form-control" name="referral_commission" type="number" value="{{ getAmount(gs('referral_commission')) }}" min="0" step="any">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>
                                        @lang('How Many Times')
                                        <i class="fas fa-info-circle text--primary" title="@lang('The number of times a referrer get commission from a single referee.')"></i>
                                    </label>
                                    <input class="form-control" name="commission_count" type="number" value="{{ gs('commission_count') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
            </div>
        </div>
    </form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        })(jQuery);
    </script>
@endpush
