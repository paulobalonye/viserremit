<?php

namespace App\Http\Controllers\Gateway;

use App\Models\User;
use App\Models\Agent;
use App\Models\Deposit;
use App\Constants\Status;
use App\Models\SendMoney;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Lib\ProcessSendMoney;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();
        $pageTitle = 'Deposit Methods';
        return view('agent.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|gt:0',
            'gateway'  => 'required',
            'currency' => 'required',
        ]);

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please gateway payment limit'];
            return back()->withNotify($notify);
        }

        $data = new Deposit();
        $trx = $trx  = session()->get('payment_trx');

        if (auth()->user()) {
            $sendMoney  = SendMoney::where('trx', $trx)->with('deposit', 'sendingCountry:id,rate')->first();
            if (!$sendMoney) {
                $notify[] = ['error', 'Session invalid'];
                return to_route('user.send.money.history')->withNotify($notify);
            }
            $rate = $sendMoney->sendingCountry->rate;
            if ($sendMoney->deposit) {
                $data = $sendMoney->deposit;
            }
            $userType = 'user';
            if ($sendMoney->payment_status != Status::PAYMENT_INITIATE && $sendMoney->payment_status != Status::PAYMENT_REJECT) {
                $notify[] = ['error', 'Payment for this send-money is already completed'];
                return to_route('user.send.money.history')->withNotify($notify);
            }
            $data->user_id       = auth()->user()->id;
            $amount              = $sendMoney->base_currency_amount + $sendMoney->base_currency_charge;
            $data->trx           = $trx;
            $data->send_money_id = $sendMoney->id;
            $urlPath = route('user.send.money.history');
        } else {
            $data->agent_id = authAgent()->id;
            $amount         = $request->amount;
            $data->trx      = getTrx();
            $rate           = $gate->rate;
            $userType       = 'agent';
            $urlPath = route('agent.deposit.history');
        }

        $charge = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable = $amount + $charge;
        $finalAmount = $payable * $rate;

        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amount = $finalAmount;
        $data->btc_amount = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->success_url = $urlPath;
        $data->failed_url = $urlPath;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route($userType . '.deposit.confirm');
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            abort(404);
        }
        $data = Deposit::where('id', $id)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);

        if ($data->user_id) {
            return to_route('user.deposit.confirm');
        } else {
            return to_route('agent.deposit.confirm');
        }
    }

    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)
            ->where('status', Status::PAYMENT_INITIATE)
            ->orderBy('id', 'DESC')
            ->with('gateway', 'user', 'agent')
            ->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return $deposit->user_id ? to_route('user.deposit.manual.confirm') : to_route('agent.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return back()->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }
        if ($deposit->user_id) {
            $pageTitle = 'Confirm Payment';
            return view("Template::$data->view", compact('data', 'pageTitle', 'deposit'));
        }

        $pageTitle = 'Confirm Deposit';
        return view($data->view, compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $methodName = $deposit->methodName();
            if ($deposit->user_id) {
                $sendMoney = $deposit->sendMoney;

                if (@$sendMoney->payment_status != Status::PAYMENT_SUCCESS) {
                    ProcessSendMoney::updateSendMoney($sendMoney, $sendMoney->user);
                }

                $transaction               = new Transaction();
                $transaction->user_id      = $deposit->user_id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $deposit->user->balance + $deposit->amount;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '+';
                $transaction->remark       = 'send_money_in';
                $transaction->details      = 'Money added for payment via' . $methodName;
                $transaction->trx          = $deposit->trx;
                $transaction->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $deposit->user_id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $deposit->user->balance;
                $transaction->charge       = 0;
                $transaction->trx_type     = '-';
                $transaction->remark       = 'send_money_out';
                $transaction->details      = 'Amount subtracted to pay';
                $transaction->trx          = $deposit->trx;
                $transaction->save();
            } else if ($deposit->agent_id) {
                $agent = Agent::find($deposit->agent_id);
                $agent->balance += $deposit->amount;
                $agent->save();

                $transaction               = new Transaction();
                $transaction->agent_id     = $deposit->agent_id;
                $transaction->amount       = $deposit->amount;
                $transaction->post_balance = $agent->balance;
                $transaction->charge       = $deposit->charge;
                $transaction->trx_type     = '+';
                $transaction->remark       = 'deposit';
                $transaction->details      = 'Deposited via ' . $methodName;
                $transaction->trx          = $deposit->trx;
                $transaction->save();

                if (!$isManual) {
                    $adminNotification            = new AdminNotification();
                    $adminNotification->agent_id  = $agent->id;
                    $adminNotification->title     = 'Deposit succeeded via ' . $methodName;
                    $adminNotification->click_url = urlPath('admin.deposit.successful');
                    $adminNotification->save();
                }

                if ($deposit->agent_id) {
                    notify($agent, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                        'method_name'     => $methodName,
                        'method_currency' => $deposit->method_currency,
                        'method_amount'   => showAmount($deposit->final_amount, currencyFormat: false),
                        'amount'          => showAmount($deposit->amount, currencyFormat: false),
                        'charge'          => showAmount($deposit->charge, currencyFormat: false),
                        'rate'            => showAmount($deposit->rate, currencyFormat: false),
                        'trx'             => $deposit->trx,
                        'post_balance'    => showAmount($agent->balance, currencyFormat: false)
                    ]);
                }
            }
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        abort_if(!$data, 404);
        if ($data->method_code > 999) {
            $method       = $data->gatewayCurrency();
            $gateway      = $method->method;
            $pageTitle    =  $data->user_id ? 'Confirm Payment' : 'Confirm Deposit';
            $templateView = $data->user_id ? 'Template::user.payment.manual' : 'agent.payment.manual';
            return view($templateView, compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();
        abort_if(!$data, 404);
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $adminNotification = new AdminNotification();

        if ($data->user_id) {
            $user = $data->user;
            $adminNotification->user_id = $user->id;

            $sendMoney = @$data->sendMoney;
            $sendMoney->payment_status  = Status::PAYMENT_PENDING;
            $sendMoney->save();

            $notify[] = ['success', 'Your payment request has been taken'];
        } else {
            $user = $data->agent;
            $adminNotification->agent_id = $user->id;
            $notify[] = ['success', 'Your deposit request has been taken'];

            notify($user, 'DEPOSIT_REQUEST', [
                'method_name'     => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
                'amount'          => showAmount($data->amount, currencyFormat: false),
                'charge'          => showAmount($data->charge, currencyFormat: false),
                'rate'            => showAmount($data->rate, currencyFormat: false),
                'trx'             => $data->trx
            ]);
        }
        $adminNotification->title = ($data->user_id ? 'Payment request from ' : 'Deposit request from ') . $user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        return redirect($data->success_url)->withNotify($notify);
    }
}
