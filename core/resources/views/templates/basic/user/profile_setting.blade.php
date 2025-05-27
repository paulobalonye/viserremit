@extends($activeTemplate . 'layouts.master')
@php
    $referralContent = getContent('referral.content', true);
@endphp
@section('content')
    <div class="section section--xl">
        <div class="container">
            <div class="row justify-content-center">
                @if (gs('referral_system'))
                    <div class="col-12">
                        <div class="card custom--card mb-5">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Refer & Enjoy the Bonus')</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="text" name="key"
                                            value="{{ route('home') }}?reference={{ $user->username }}"
                                            class="form-control form--control referralURL" readonly>
                                        <button type="button" class="input-group-text copytext" id="copyBoard">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __($pageTitle) }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form class="register" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('First Name')
                                        </label>
                                        <input type="text" class="form-control form--control" name="firstname"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Last Name')
                                        </label>
                                        <input type="text" class="form-control form--control" name="lastname"
                                            value="{{ $user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('E-mail Address')
                                        </label>
                                        <input class="form-control form--control" value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Mobile Number')
                                        </label>
                                        <input class="form-control form--control" value="{{ $user->mobile }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Address')
                                        </label>
                                        <input type="text" class="form-control form--control" name="address"
                                            value="{{ @$user->address }}">
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('State')
                                        </label>
                                        <input type="text" class="form-control form--control" name="state"
                                            value="{{ @$user->state }}">
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Zip Code')
                                        </label>
                                        <input type="text" class="form-control form--control" name="zip"
                                            value="{{ @$user->zip }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('City')
                                        </label>
                                        <input type="text" class="form-control form--control" name="city"
                                            value="{{ @$user->city }}">
                                    </div>
                                    <div class="form-group col-sm-4 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Country')
                                        </label>
                                        <input class="form-control form--control" value="{{ @$user->country_name }}"
                                            disabled>
                                    </div>
                                    <div class="form-group col-sm-4 mb-3">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Acount Type')
                                        </label>
                                        @if ($user->type == Status::PERSONAL_USER)
                                            <input class="form-control form--control" value="Personal" disabled>
                                        @else
                                            <input class="form-control form--control" value="Business" disabled>
                                        @endif
                                    </div>
                                </div>
                                @if ($user->type == Status::BUSINESS_USER)
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            @if ($user->business_profile_data)
                                                <ul class="list-group ">
                                                    @foreach ($user->business_profile_data as $val)
                                                        @continue(!$val->value)
                                                        <li
                                                            class="list-group-item list-group-flush d-flex justify-content-between align-items-center py-3">
                                                            {{ __($val->name) }}
                                                            <span>
                                                                @if ($val->type == 'checkbox')
                                                                    {{ implode(',', $val->value) }}
                                                                @elseif($val->type == 'file')
                                                                    @if ($val->value)
                                                                        <a href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                                                            class="me-3">
                                                                            <i class="fa fa-file"></i>
                                                                            @lang('Attachment')
                                                                        </a>
                                                                    @else
                                                                        @lang('No File')
                                                                    @endif
                                                                @else
                                                                    <p class="m-0">{{ __($val->value) }}</p>
                                                                @endif
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                        </div>
                                    </div>
                                @endif
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn--base w-100 btn--xl">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .copied::after {
            background-color: #{{ gs('base_color') }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
