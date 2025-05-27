@extends('agent.layouts.app')
@section('panel')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="border--card">
                <h5 class="title"><i class="las la-wallet"></i>{{ $pageTitle }}</h5>
                <div class="card-body p-0">
                    <form action="{{ route('agent.deposit.manual.update') }}" method="POST" class="disableSubmission" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-primary">
                                    <p class="mb-0"><i class="las la-info-circle"></i> @lang('You are requesting') <b>{{ showAmount($data['amount'])  }}</b> @lang('to payment.') @lang('Please pay')
                                        <b>{{showAmount($data['final_amount'],currencyFormat:false) .' '.$data['method_currency'] }} </b> @lang('for successful payment.')</p>
                                </div>
                                <div class="mb-3">@php echo  $data->gateway->description @endphp</div>
                            </div>
                            <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}"/>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
