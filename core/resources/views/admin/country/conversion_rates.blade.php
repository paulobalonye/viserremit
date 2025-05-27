@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-body">
            @if ($countries->count())
                <form method="POST">
                    @csrf
                    <div class="row">
                        @foreach ($countries as $item)
                            @php
                                $rate = $rates->where('to_country', $item->id)->first();
                                $value = $rate->rate ?? null;
                            @endphp
                            <div class="col-lg-6 col-xl-3">
                                <div class="form-group">
                                    <label>{{ $country->currency }} @lang('to') {{ $item->currency }}</label>
                                    <input name="data[{{ $loop->index }}][from_country]" type="hidden"
                                        value="{{ $country->id }}">
                                    <input name="data[{{ $loop->index }}][to_country]" type="hidden"
                                        value="{{ $item->id }}">
                                    <div class="input-group">
                                        <span class="input-group-text">1 {{ $country->currency }} = </span>
                                        <input class="form-control" name="data[{{ $loop->index }}][rate]" type="number"
                                            value="{{ $value }}" step="any">
                                        <span class="input-group-text">{{ $item->currency }} </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            <button class="btn w-100 btn--primary h-45" type="submit">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <h3 class="text--danger">@lang('Add more countries')</h3>
                </div>
            @endif
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn--sm btn-outline--primary confirmationBtn" data-question="@lang('To sync successfully via the API, ensure the conversion rate API is configured. Are you sure you want to proceed with this currency conversion synchronization?')"
        data-action="{{ route('admin.country.currency.conversion.synchronize', $country->id) }}">
        <i class="la la-sync"></i> @lang('Sync Via API')
    </button>
    <x-back route="{{ route('admin.country.index') }}"></x-back>
@endpush
