@extends('agent.layouts.app')
@section('panel')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="border--card">
                <h5 class="title"><i class="la la-wallet"></i> @lang('Payment via Paystack')</h5>
                <div class="card-body p-0">
                    <form action="{{ route('ipn.' . $deposit->gateway->alias) }}" method="POST"
                        class="text-center disableSubmission">
                        @csrf
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                @lang('You have to pay '):
                                <strong>
                                    {{ showAmount($deposit->final_amount, currencyFormat: false) }}
                                    {{ __($deposit->method_currency) }}
                                </strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                @lang('You will get '):
                                <strong>{{ showAmount($deposit->amount) }}</strong>
                            </li>
                        </ul>
                        <button type="button" class="btn btn--base btn-md w-100 mt-3" id="btn-confirm">
                            @lang('Pay Now')
                        </button>
                        <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}"
                            data-amount="{{ round($data->amount) }}" data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}"
                            data-custom-button="btn-confirm"></script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
