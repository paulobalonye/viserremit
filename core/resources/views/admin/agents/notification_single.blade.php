@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.agents.notification.single', $agent->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>@lang('Subject') </label>
                                <input class="form-control" name="subject" placeholder="@lang('Email subject')" required
                                    type="text" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('Message') </label>
                                <textarea class="form-control nicEdit" name="message" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn w-100 h-45 btn--primary" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <span class="text--primary">@lang('Notification will send via ')
        @if (gs('en'))
            <span class="badge badge--warning">@lang('Email')</span>
        @endif
        @if (gs('sn'))
            <span class="badge badge--warning">@lang('SMS')</span>
        @endif
    </span>
@endpush
