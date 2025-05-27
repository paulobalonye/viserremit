@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section section--xl">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                @lang('To get access to your dashboard, you need to complete your profile by submitting the below form with proper information.')
                            </div>
                            <form method="POST" class="disableSubmission viser-form" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Username')
                                        </label>
                                        <input type="text" class="form-control form--control checkUser" name="username"
                                            value="{{ old('username') }}" required />
                                        <small class="text--danger usernameExist"></small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Country')
                                        </label>
                                        <select name="country" class="form-control form--control select2-basic" required>
                                            @foreach ($countries as $key => $country)
                                                <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->country }}" data-code="{{ $key }}">
                                                    {{ __($country->country) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Mobile')
                                        </label>
                                        <div class="input-group ">
                                            <span class="input-group-text mobile-code"></span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                class="form-control form--control checkUser" required>
                                        </div>
                                        <small class="text--danger mobileExist"></small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Address')
                                        </label>
                                        <input type="text" class="form-control form--control" name="address"
                                            value="{{ old('address') }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('State')
                                        </label>
                                        <input type="text" class="form-control form--control" name="state"
                                            value="{{ old('state') }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('Zip')
                                        </label>
                                        <input type="text" class="form-control form--control" name="zip"
                                            value="{{ old('zip') }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label sm-text t-heading-font heading-clr fw-md">
                                            @lang('City')
                                        </label>
                                        <input type="text" class="form-control form--control" name="city"
                                            value="{{ old('city') }}" required>
                                    </div>
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    @if ($user->type == Status::BUSINESS_USER)
                                        <div class="col-12">
                                            <x-viser-form identifier="act" identifierValue="business-account.data" />
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100 btn--xl">
                                            @lang('Submit')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
