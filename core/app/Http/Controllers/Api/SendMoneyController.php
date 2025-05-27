<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\ProcessSendMoney;
use App\Models\Country;
use App\Models\CountryDeliveryMethod;
use App\Models\Form;
use App\Models\Recipient;
use App\Models\SendingPurpose;
use App\Models\SendMoney;
use App\Models\Service;
use App\Models\SourceOfFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendMoneyController extends Controller
{
    public function sendMoney()
    {
        $sources            = SourceOfFund::active()->get();
        $purposes           = SendingPurpose::active()->get();
        $sessionData        = session()->get('send_money') ?? [];
        $recipientCountryId = null;
        $deliveryMethodId   = null;
        $sendingCountries   = Country::active()->sending()->with('conversionRates')->get();
        $receivingCountries = Country::receivableCountries()->get();

        if ($sessionData) {
            $sendingCountryId   = $sendingCountries->where('id', $sessionData['sending_country'])->first()->id;
            $recipientCountryId = $receivingCountries->where('id', $sessionData['recipient_country'])->first()->id;
            $deliveryMethodId   = $sessionData['delivery_method'];
        } else {
            $ipInfo           = json_decode(json_encode(getIpInfo()), true);
            $countryName      = @implode(',', $ipInfo['country']);
            $sendingCountryId = @$sendingCountries->where('name', $countryName)->first()->id ?? @$sendingCountries->first()->id;
        }

        $todaySendMoney     = SendMoney::whereIn('status', [Status::SEND_MONEY_PENDING, Status::SEND_MONEY_COMPLETED])
            ->where('user_id', auth()->id())
            ->whereDate('created_at', now())
            ->sum('base_currency_amount');
        $thisMonthSendMoney = SendMoney::whereIn('status', [Status::SEND_MONEY_PENDING, Status::SEND_MONEY_COMPLETED])
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->sum('base_currency_amount');

        $recipients = Recipient::where('user_id', auth()->user()->id)->get();
        $sendingAmount      = @$sessionData['sending_amount'];
        $recipientAmount    = @$sessionData['recipient_amount'];

        session()->forget('send_money');

        return response()->json([
            'remark' => 'send_money',
            'status' => 'success',
            'data' => [
                'recipients'           => $recipients,
                'sources'              => $sources,
                'purposes'             => $purposes,
                'sending_amount'       => $sendingAmount,
                'recipient_amount'     => $recipientAmount,
                'sending_country_id'   => $sendingCountryId,
                'recipient_country_id' => $recipientCountryId,
                'sending_countries'    => $sendingCountries,
                'receiving_countries'  => $receivingCountries,
                'delivery_method_id'   => $deliveryMethodId,
                'today_send_money'     => $todaySendMoney,
                'this_month_sendMoney' => $thisMonthSendMoney,
            ],
        ]);
    }

    public function saveMoney(Request $request)
    {
        $rules =  [
            'sending_amount'    => 'required|numeric|gt:0',
            'sending_country'   => 'required|gt:0',
            'recipient_country' => 'required|gt:0',
            'payment_type'      => 'required|in:1,2',
            'source_of_funds'   => 'required|gt:0',
            'sending_purpose'   => 'required|gt:0',
            'recipient'         => 'required|array|min:3',
            'recipient.*'       => 'required|string',
            'delivery_method'   => 'required|numeric',
            'service'           => 'nullable|required_unless:delivery_method,0|integer'
        ];

        $messages = [
            'recipient.name.required'    => 'Recipient name field is required',
            'recipient.mobile.required'  => 'Recipient mobile number field is required',
            'recipient.address.required' => 'Recipient address field is required',
            'service.required_unless'    => 'Service field is required if delivery method is not an agent'
        ];

        $serviceFormData = null;

        if ($request->service) {
            $service        = Service::find($request->service);
            if (!$service) {
                return response()->json([
                    $notify[] = 'Invalid Service',
                    'remark' => 'service',
                    'status' => 'error',
                    'message' => ['error' => $notify],

                ]);
            }

            $form = Form::where('act', 'service_form')->find($service->form_id);
            if (!$form) {
                return response()->json([
                    'remark' => 'service_form',
                    'status' => 'error',
                    'message' => ['error' => 'Invalid request']
                ]);
            }

            $formData       = $form->form_data;
            $formProcessor  = new FormProcessor();
            $validationRule = $formProcessor->valueValidation($formData);
            $validator = Validator::make($request->all(), $validationRule);
            if ($validator->fails()) {
                return response()->json([
                    'remark' => 'service_form_validation_error',
                    'status' => 'error',
                    'message' => ['error' => $validator->errors()->all()],
                ]);
            }
            $serviceFormData = $formProcessor->processFormData($request, $formData);
        } else {
            $request->validate($rules, $messages);
        }

        if ($request->delivery_method) {
            $countryDeliveryMethod = CountryDeliveryMethod::where('country_id', $request->recipient_country)->where('delivery_method_id', $request->delivery_method)->exists();
        } else {
            if (gs()->agent_module) {
                $receivingCountry = Country::find($request->recipient_country);
                if (!$receivingCountry) {
                    return response()->json([
                        'remark' => 'receiving_country',
                        'status' => 'error',
                        'message' => ['error' => 'Receiving country not found']
                    ]);
                }
                if ($receivingCountry->has_agent) {
                    $countryDeliveryMethod = true;
                } else {
                    $countryDeliveryMethod = false;
                }
            } else {
                $countryDeliveryMethod = false;
            }
        }

        if (!$countryDeliveryMethod) {
            return response()->json([
                $notify[] = 'Invalid delivery method selected',
                'remark' => 'delivery_method',
                'status' => 'error',
                'message' => ['error' => $notify],

            ]);
        }

        $user    = auth()->user();
        $payment = new ProcessSendMoney();

        if ($request->payment_type == 1 && $payment->amountWithCharge > $user->balance) {
            return response()->json([
                $notify[] = 'Insufficient balance',
                'remark' => 'insufficient_balance',
                'status' => 'error',
                'message' => ['error' => $notify],

            ]);
        }

        $payment->user       = $user;
        $payment->columnName = 'user_id';
        $sendMoney           = $payment->createSendMoney($request, $serviceFormData);

        if ($request->payment_type == 1) {
            $payment->createTransaction();
            ProcessSendMoney::updateSendMoney($sendMoney, $user);
        }
        session()->put('payment_trx', $sendMoney->trx);

        $notify[] = ['success', 'Send money request submitted successfully'];
        return response()->json([
            'remark' => 'send_money',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'payment_type' => $request->payment_type == 1 ? 'Refunded_payment' : 'Direct_payment',
                'send_money' => $sendMoney,
            ]
        ]);
    }

    public function history()
    {
        $transfers    = SendMoney::with('deposit.gateway', 'recipientCountry', 'countryDeliveryMethod.deliveryMethod')->filterUser()->latest()->paginate(getPaginate());

        return response()->json([
            'status' => 'success',
            'data' => [
                'transfers' => $transfers,
            ],
        ]);
    }

    public function getServices(Request $request)
    {
        $services = [];
        if ($request->country_id && $request->delivery_method_id) {
            $countryDeliveryMethod = CountryDeliveryMethod::where('country_id', $request->country_id)
                ->where('delivery_method_id', $request->delivery_method_id)
                ->first();
            if ($countryDeliveryMethod) {
                $services = Service::where('country_delivery_method_id', $countryDeliveryMethod->id)->with('form')->orderBy('name')->get();
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'services' => $services
            ]
        ]);
    }

    public function sendMoneyDetail($id)
    {
        $sendMoney = SendMoney::where('user_id', auth()->id())->find($id);
        if (!$sendMoney) {
            return response()->json([
                'remark' => 'send_money_detail',
                'status' => 'error',
                "message" => ['error' => 'Invalid request']
            ]);
        }

        return response()->json([
            'remark' => 'send_money_detail',
            'status' => 'success',
            'data' => [
                'send_money' => $sendMoney,
            ]
        ]);
    }
}
