@extends('admin.layouts.app')
@section('panel')
    <form method="POST">
        @csrf
        <div class="row gy-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> @lang('Currency conversion API')</label>
                                    <input name="status" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-bs-toggle="toggle" data-height="35"
                                        data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox"
                                        @checked(gs('conversion_rate_api')?->status)>
                                </div>
                            </div>
                        </div>
                        <div class="row api-setting">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Conversion Rate Provider') <i
                                            class="apiHelpModelButton text--primary fas fa-info-circle cursor-pointer"
                                            data-bs-toggle="tooltip" title="Click for details"></i> </label>
                                    <select class="form-control select2" data-minimum-results-for-search="-1"
                                        name="provider">
                                        @foreach ($providers as $key => $provider)
                                            <option
                                                data-image="{{ getImage(getFilePath('conversionRate') . "/$key.jpg") }}"
                                                data-url="{{ @$provider['url'] }}"
                                                data-name="{{ __(@$provider['name']) }}" value="{{ $key }}"
                                                @selected(gs('conversion_rate_api')?->provider == $key)>
                                                {{ __(@$provider['name']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 credentials openexchangerates">
                                <div class="form-group">
                                    <label class="required">@lang('App ID')</label>
                                    <input class="form-control" name="openexchangerates[app_id]" type="text"
                                        value="{{ @gs('conversion_rate_api')?->openexchangerates?->app_id }}"
                                        placeholder="************">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 credentials currencyapi">
                                <div class="form-group">
                                    <label class="required">@lang('API Key')</label>
                                    <input class="form-control" name="currencyapi[apikey]" type="text"
                                        value="{{ @gs('conversion_rate_api')?->currencyapi?->apikey }}"
                                        placeholder="************">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 credentials exchangerate">
                                <div class="form-group">
                                    <label class="required">@lang('API Key')</label>
                                    <input class="form-control" name="exchangerate[api_key]" type="text"
                                        value="{{ @gs('conversion_rate_api')?->exchangerate?->api_key }}"
                                        placeholder="************">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="border-line-area mt-2">
                                    <h6 class="border-line-title fw-bold">@lang('Adjustment Settings')</h6>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Fixed Adjustment') <i class="text--primary fas fa-info-circle cursor-pointer"
                                            data-bs-toggle="tooltip"
                                            title="Add or subtract this value from the primary conversion based on its sign. Input 0 to leave it unchanged."></i></label>
                                    <input class="form-control" name="fixed_adjustment" type="number"
                                        value="{{ gs('conversion_rate_api')?->fixed_adjustment }}" step="any"
                                        placeholder="@lang('amount can be (+) plus or (-) minus')" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Percent Adjustment') <i class="text--primary fas fa-info-circle cursor-pointer"
                                            data-bs-toggle="tooltip"
                                            title="Add or subtract this percentage from the primary conversion based on its sign. Input 0 to leave it unchanged."></i></label>
                                    <div class="input-group">
                                        <input class="form-control" name="percent_adjustment" type="number"
                                            value="{{ gs('conversion_rate_api')?->percent_adjustment }}" step="any"
                                            placeholder="@lang('percent can be (+) plus or (-) minus')" required>
                                        <div class="input-group-text">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label> @lang('Automatic Synchronization')</label>
                                    <input name="auto_synchronization" data-width="100%" data-size="large"
                                        data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                        data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')"
                                        type="checkbox" @checked(gs('conversion_rate_api')?->auto_synchronization ?? true)>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="apiHelpModel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        @lang('1. Access') <a class="provider-url" href=""></a> @lang('and log in.')
                    </p>
                    <p>
                        @lang('2. Retrieve credentials from the respective menu. Refer to the provided sample image for guidance.')
                    </p>
                    <img class="provider-image my-3 rounded border" src="">
                </div>
                <div class="modal-footer">
                    <button class="btn btn--danger" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* text middle border line start */
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }

        .border-line-area::before {
            position: absolute;
            content: "";
            top: 36%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }

        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
            border-radius: 20px;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('[name="status"]').on('change', function() {
                $('.api-setting').toggleClass('d-none', !$(this).prop('checked'));
                if ($(this).prop('checked')) {
                    $('[name=percent_adjustment],[name=fixed_adjustment]').attr('required', 'required');
                } else {
                    $('[name=percent_adjustment],[name=fixed_adjustment]').removeAttr('required');
                }
            }).change();
            $('[name="provider"]').on('change', function() {
                $('.credentials').addClass('d-none');
                $(`.${$(this).val()}`).removeClass('d-none');
            }).change();
            var apiHelpModel = $('#apiHelpModel');
            $('.apiHelpModelButton').on('click', function() {
                var data = $('[name="provider"] option:selected').data();
                apiHelpModel.find('.modal-title').text(`${data.name} @lang('Information')`);
                apiHelpModel.find('.modal-body .provider-url').attr('href', data.url);
                apiHelpModel.find('.modal-body .provider-url').html(data.url);
                apiHelpModel.find('.modal-body .provider-image').attr('src', data.image);
                apiHelpModel.modal('show');
            });
        })(jQuery);
    </script>
@endpush
