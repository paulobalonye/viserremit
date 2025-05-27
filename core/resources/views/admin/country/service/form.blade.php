@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.service.add.update', $service->id ?? 0) }}" enctype="multipart/form-data" method="post">
        <div class="row gy-3">
            <div class="col-12">
                <div class="card">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select class="form-control select2" name="country_id" required>
                                        <option disabled selected value="">@lang('Select One')</option>
                                        @foreach ($countries as $country)
                                            <option @selected(@$service->countryDeliveryMethod->country_id == $country->id) value="{{ $country->id }}">
                                                {{ __($country->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Delivery Method')</label>
                                    <select class="form-control select2" data-minimum-results-for-search="-1"
                                        name="delivery_method_id" required>
                                        <option disabled selected value="">@lang('Select One')</option>
                                        @foreach ($deliveryMethods as $deliveryMethod)
                                            <option @selected(@$service->countryDeliveryMethod->delivery_method_id == $deliveryMethod->id) value="{{ $deliveryMethod->id }}">
                                                {{ __($deliveryMethod->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Service Name')</label>
                                    <input class="form-control" name="name" required type="text"
                                        value="{{ old('name', @$service->name) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border--primary">
                    <div class="card-header bg--primary d-flex justify-content-between">
                        <h5 class="text-white">@lang('Form for User')</h5>
                        <button class="btn btn-sm btn-outline-light float-end form-generate-btn" type="button">
                            <i class="la la-fw la-plus"></i>@lang('Add New')
                        </button>
                    </div>
                    <div class="card-body">
                        @php $formData = $service->form ?? []; @endphp
                        <x-generated-form :form=$formData />
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
            </div>
        </div>
    </form>

    <x-form-generator-modal />
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.service.index') }}" />
@endpush
