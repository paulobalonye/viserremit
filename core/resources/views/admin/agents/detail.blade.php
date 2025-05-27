@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="6" link="{{ route('admin.report.transaction') }}?search={{ $agent->username }}"
                        title="Balance" icon="las la-money-bill-wave-alt" value="{{ showAmount($agent->balance) }}"
                        bg="indigo" type="2" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="6" link="{{ route('admin.deposit.list') }}?search={{ $agent->username }}"
                        title="Deposits" icon="las la-wallet" value="{{ showAmount($totalDeposit) }}" bg="8"
                        type="2" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="6" link="{{ route('admin.withdraw.data.all') }}?search={{ $agent->username }}"
                        title="Withdrawals" icon="la la-bank" value="{{ showAmount($totalWithdrawals) }}" bg="6"
                        type="2" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="6" link="{{ route('admin.report.transaction') }}?search={{ $agent->username }}"
                        title="Transactions" icon="las la-exchange-alt" value="{{ $totalTransaction }}" bg="17"
                        type="2" />
                </div>
            </div>
            <div class="d-flex mt-4 flex-wrap gap-3">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                        class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"> </i> @lang('Balance')
                    </button>
                </div>
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                        class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"> </i> @lang('Balance')
                    </button>
                </div>
                <div class="flex-fill">
                    <a href="{{ route('admin.report.login.history') }}?search={{ $agent->username }}"
                        class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"> </i> @lang('Logins')
                    </a>
                </div>
                <div class="flex-fill">
                    <a href="{{ route('admin.agents.notification.log', $agent->id) }}"
                        class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"> </i> @lang('Notifications')
                    </a>
                </div>
                @if ($agent->kyc_data)
                    <div class="flex-fill">
                        <a href="{{ route('admin.agents.kyc.details', $agent->id) }}" target="_blank"
                            class="btn btn--dark btn--shadow w-100 btn-lg">
                            <i class="las la-user-check"> </i> @lang('KYC Data')
                        </a>
                    </div>
                @endif
                <div class="flex-fill">
                    @if ($agent->status == Status::ENABLE)
                        <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg agentStatus"
                            data-bs-toggle="modal" data-bs-target="#agentStatusModal">
                            <i class="las la-ban"></i> @lang('Ban Agent')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg agentStatus"
                            data-bs-toggle="modal" data-bs-target="#agentStatusModal">
                            <i class="las la-undo"></i> @lang('Unban Agent')
                        </button>
                    @endif
                </div>
            </div>
            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $agent->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.agents.update', [$agent->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required
                                        value="{{ $agent->firstname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label cl~ass="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                        value="{{ $agent->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{ $agent->email }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile"
                                            class="form-control checkAgent" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ @$agent->address }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$agent->city }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$agent->state }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ @$agent->zip }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        @foreach ($countries as $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->id }}">{{ __($country->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                    data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                    data-off="@lang('Disable')" name="ts"
                                    @if ($agent->ts) checked @endif>
                            </div>
                            <div class="form-group col-6">
                                <label>@lang('KYC') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                    data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                    data-off="@lang('Unverified')" name="kv"
                                    @if ($agent->kv == 1) checked @endif>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.agents.add.sub.balance', $agent->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="agentStatusModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($agent->status == Status::ENABLE)
                            <span>@lang('Ban Agent')</span>
                        @else
                            <span>@lang('Unban Agent')</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.agents.status', $agent->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($agent->status == Status::ENABLE)
                            <h6 class="mb-2">@lang('If you ban this agent he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $agent->ban_reason }}</p>
                            <h4 class="mt-3 text-center">@lang('Are you sure to unban this agent?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($agent->status == Status::ENABLE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark"
                                data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.agents.login', $agent->id) }}" target="_blank" class="btn btn-sm btn-outline--primary">
        <i class="las la-sign-in-alt"></i>@lang('Login as Agent')
    </a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"
            $('.bal-btn').on('click', function() {

                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);

                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{ @$agent->country_id }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $agent->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
@endpush
