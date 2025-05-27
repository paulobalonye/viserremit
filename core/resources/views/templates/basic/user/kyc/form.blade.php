@extends($activeTemplate . 'layouts.master')
@php
    $user = auth()->user();
@endphp
@section('content')
    <div class="section section--xl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __($pageTitle) }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data" class="disableSubmission viser-form">
                                @csrf
                                @if ($user->type == Status::BUSINESS_USER)
                                    <x-viser-form identifier="act" identifierValue="business-user.kyc" />
                                @else
                                    <x-viser-form identifier="act" identifierValue="personal-user.kyc" />
                                @endif
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn--xl  w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
