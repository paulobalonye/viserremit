@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th class="text-start">@lang('Name')</th>
                                    <th>@lang('Currency')</th>
                                    <th>@lang('Rate')</th>
                                    <th>@lang('Has Agent')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($countries as $country)
                                    <tr>
                                        <td class="text-start">
                                            <span class="user">
                                                <span class="thumb me-2">
                                                    <img alt="image"
                                                        src="{{ getImage(getFilePath('country') . '/' . $country->image, getFileSize('country')) }}">
                                                </span>
                                                {{ $country->name }}
                                            </span>
                                        </td>
                                        <td>{{ $country->currency }}</td>
                                        <td>
                                            {{ showAmount(1) }} = {{ showAmount($country->rate, currencyFormat: false) }}
                                            {{ $country->currency }}
                                        </td>
                                        <td>@php echo $country->agentStatus;@endphp</td>
                                        <td>@php echo $country->statusBadge;@endphp</td>
                                        @php
                                            $country->image_with_path = getImage(
                                                getFilePath('country') . '/' . $country->image,
                                                getFileSize('country'),
                                            );
                                        @endphp
                                        <td>
                                            <button aria-expanded="false" class="btn btn-outline--info btn--sm"
                                                data-bs-toggle="dropdown" type="button">
                                                <i class="las la-ellipsis-v"></i>@lang('More')
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item cuModalBtn editBtn" data-has_status="true"
                                                    data-modal_title="@lang('Update Country')" data-resource="{{ $country }}"
                                                    data-image="{{ getImage(getFilePath('country') . '/' . $country->image, getFileSize('country')) }}">
                                                    <i class="la la-pencil-alt"></i> @lang('Edit')
                                                </button>
                                                @if ($country->status)
                                                    <button class="dropdown-item confirmationBtn"
                                                        data-action="{{ route('admin.country.update.status', $country->id) }}"
                                                        data-question="@lang('Are you sure that you want to disable this country?')">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="dropdown-item confirmationBtn"
                                                        data-action="{{ route('admin.country.update.status', $country->id) }}"
                                                        data-question="@lang('Are you sure that you want to enable this country?')">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @endif
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.country.currency.conversion.rate', $country->id) }}">
                                                    <i class="la la-coins"></i> @lang('Conversion Rates')
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.service.index', $country->id) }}">
                                                    <i class="las la-list"></i> @lang('Services')
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.country.charges.set', $country->id) }}">
                                                    <i class="las la-comment-dollar"></i> @lang('Set Charges')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($countries->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($countries) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ADD METHOD MODAL --}}
    <div class="modal fade" id="cuModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.country.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <x-image-uploader :imagePath="getImage(null, getFileSize('country'))" :size="getFileSize('country')" class="w-100" id="imageCreate" :required="true" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>@lang('Country') </label>
                                    <select class="form-control select2" name="country_code" required>
                                        <option disabled selected value="">@lang('Select One')</option>
                                        @foreach ($countryList as $shortCode => $countryData)
                                            <option data-currency="{{ @$countryData->currency->code }}"
                                                value="{{ $shortCode }}">
                                                {{ $countryData->country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Currency') </label>
                                    <input class="form-control bg--white" name="currency" readonly type="text"
                                        value="{{ old('currency') }}" />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Rate')</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            {{ showAmount(1) }} =
                                        </span>
                                        <input class="form-control" name="rate" required step="any" type="number"
                                            value="{{ old('rate') }}" />
                                        <span class="input-group-text currency">{{ old('currency') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Has Agent')</label>
                                    <input data-height="45" data-off="@lang('No')" data-offstyle="-danger"
                                        data-on="@lang('Yes')" data-onstyle="-success" data-size="large"
                                        data-toggle="toggle" data-width="100%" name="has_agent" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Sending Country')</label>
                                    <input data-height="45" data-off="@lang('No')" data-offstyle="-danger"
                                        data-on="@lang('Yes')" data-onstyle="-success" data-size="large"
                                        data-toggle="toggle" data-width="100%" name="is_sending" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Receiving Country')</label>
                                    <input data-height="45" data-off="@lang('No')" data-offstyle="-danger"
                                        data-on="@lang('Yes')" data-onstyle="-success" data-size="large"
                                        data-toggle="toggle" data-width="100%" name="is_receiving" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="helpModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">@lang('Information')</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush list-group-numbered">
                        <li class="list-group-item">@lang("A country won't be displayed in the frontend if it is disabled.")</li>
                        <li class="list-group-item">@lang("A country won't be displayed as receiving country in the frontend if it has no active service.")</li>
                        <li class="list-group-item">@lang("If you don't set the conversion rate for a combination of sending and receiving countries, then the rate will be calculated by the rate in base currency.")</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Name / Currency" />
    <button class="btn btn-outline--info" data-bs-target="#helpModal" data-bs-toggle="modal" type="button">
        <i class="la la-info-circle"></i> @lang('Info')
    </button>
    <button class="btn btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Country')" type="button">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('style')
    <style>
        .table-responsive {
            overflow-x: hidden !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
                "use strict";
                let cuModal = $('#cuModal');
                $('input[name=currency]').on('input', function() {
                    $('.currency').text($(this).val());
                });

                $('.cuModalBtn').on('click', function() {
                    let countryCode = `{{ old('country_code') }}`;
                    cuModal.find('[type=checkbox]').bootstrapToggle("off");
                    let resource = $(this).data('resource');

                    if (resource) {
                        toggleSwitch(resource.has_agent, 'has_agent')
                        toggleSwitch(resource.is_sending, 'is_sending')
                        toggleSwitch(resource.is_receiving, 'is_receiving')
                        $('.currency').text(resource.currency);

                        $("[name=country_code]").val(resource.country_code).change();
                        cuModal.find('.image-upload-preview').css('background-image',
                            `url(${$(this).data('image')})`);
                    } else {
                        $("[name=country_code]").val('').change();
                        cuModal.find(".image-upload-preview").css("background-image",
                            `url({{ getImage(null, getFileSize('country')) }}`);
                    }
                });

                function toggleSwitch(data, fieldName) {
                    let element = cuModal.find(`[name=${fieldName}]`);
                        if (data) {
                            $(element).bootstrapToggle("on");
                        } else {
                            $(element).bootstrapToggle("off");
                        }
                    }

                    $('select[name=country_code]').on('change', function() {
                        $('[name=currency]').val($(this).find(':selected').data('currency'));
                        $('.currency').text($(this).find(':selected').data('currency'));
                    });

                    $('.editBtn').on('click', function() {
                        $('[type=file]').removeAttr('required');
                    });

                    cuModal.on('hidden.bs.modal', function() {
                        $('[type=file]').attr('required', true);
                    });
                })(jQuery);
    </script>
@endpush
