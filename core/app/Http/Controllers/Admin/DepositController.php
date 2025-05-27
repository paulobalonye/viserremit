<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    protected $type;
    protected $title;

    public function __construct()
    {
        $segments = request()->segments();
        if (!empty($segments)) {
            $this->type     = request()->segments()[1];
        }

        $this->title    = ucfirst($this->type);
    }

    public function pending($userId = null)
    {
        $pageTitle = "Pending " . $this->title;
        $deposits = $this->depositData('pending', userId: $userId);
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'type'));
    }


    public function approved($userId = null)
    {
        $pageTitle = "Approved " . $this->title;
        $deposits = $this->depositData('approved', userId: $userId);
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'type'));
    }

    public function successful($userId = null)
    {
        $pageTitle = "Successful " . $this->title;
        $deposits = $this->depositData('successful', userId: $userId);
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'type'));
    }

    public function rejected($userId = null)
    {
        $pageTitle = "Rejected " . $this->title;
        $deposits = $this->depositData('rejected', userId: $userId);
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'type'));
    }

    public function initiated($userId = null)
    {
        $pageTitle = "Initiated " . $this->title;
        $deposits = $this->depositData('initiated', userId: $userId);
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'type'));
    }

    public function deposit($userId = null)
    {
        $pageTitle = "All " . $this->title;
        $depositData = $this->depositData($scope = null, $summary = true, userId: $userId);
        $deposits = $depositData['data'];
        $summary = $depositData['summary'];
        $successful = $summary['successful'];
        $pending = $summary['pending'];
        $rejected = $summary['rejected'];
        $initiated = $summary['initiated'];
        $type = $this->type;
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'successful', 'pending', 'rejected', 'initiated', 'type'));
    }

    protected function depositData($scope = null, $summary = false, $userId = null)
    {
        if ($scope) {
            $deposits = Deposit::$scope()->with(['user', 'gateway', 'agent', 'sendMoney:id,mtcn_number,status']);
        } else {
            $deposits = Deposit::with(['user', 'gateway', 'agent', 'sendMoney:id,mtcn_number,status']);
        }

        if ($this->type == 'payment') {
            $deposits->payment();
            $deposits = $deposits->searchable(['trx', 'user:username'])->dateFilter();
        } else {
            $deposits->agentDeposit();
            $deposits = $deposits->searchable(['trx', 'agent:username'])->dateFilter();
        }

        $request = request();

        if ($request->method) {
            if ($request->method != Status::GOOGLE_PAY) {
                $method = Gateway::where('alias', $request->method)->firstOrFail();
                $deposits = $deposits->where('method_code', $method->code);
            } else {
                $deposits = $deposits->where('method_code', Status::GOOGLE_PAY);
            }
        }

        if (!$summary) {
            return $deposits->orderBy('id', 'desc')->paginate(getPaginate());
        } else {
            $successful = clone $deposits;
            $pending = clone $deposits;
            $rejected = clone $deposits;
            $initiated = clone $deposits;

            $successfulSummary = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummary = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummary = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');
            $initiatedSummary = $initiated->where('status', Status::PAYMENT_INITIATE)->sum('amount');

            return [
                'data' => $deposits->orderBy('id', 'desc')->paginate(getPaginate()),
                'summary' => [
                    'successful' => $successfulSummary,
                    'pending' => $pendingSummary,
                    'rejected' => $rejectedSummary,
                    'initiated' => $initiatedSummary,
                ]
            ];
        }
    }

    public function details($id)
    {
        $deposit = Deposit::where('id', $id)->with(['user', 'agent', 'gateway'])->firstOrFail();
        $pageTitle = $deposit->user->username ?? $deposit->agent->username . ' requested ' . showAmount($deposit->amount);
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        $type = $this->type;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit', 'details', 'type'));
    }

    public function approve($id)
    {
        $deposit = Deposit::where('id', $id)->where('status', Status::PAYMENT_PENDING)->firstOrFail();
        PaymentController::userDataUpdate($deposit, true);

        if ($deposit->user_id) {
            $notify[] = ['success', 'Payment request for send money approved successfully'];
            $type = 'payment';
        } elseif ($deposit->agent_id) {
            $type = 'deposit';
            $notify[] = ['success', 'Deposit request approved successfully'];
        }
        return to_route("admin.$type.pending")->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|string|max:255'
        ]);
        $deposit = Deposit::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = Status::PAYMENT_REJECT;
        $deposit->save();

        if ($deposit->user_id) {
            $sendMoney = $deposit->sendMoney;
            if ($sendMoney->status == Status::SEND_MONEY_INITIATED) {
                $sendMoney->status         = Status::SEND_MONEY_INITIATED;
                $sendMoney->payment_status = Status::PAYMENT_REJECT;
                $sendMoney->admin_feedback = $request->message;
                $sendMoney->save();
            }
            notify($deposit->user, 'PAYMENT_REJECT', [
                'trx'                => $deposit->trx,
                'sending_country'    => @$sendMoney->sendingCountry->name,
                'sending_amount'     => showAmount($sendMoney->sending_amount, currencyFormat: false),
                'sending_currency'   => $sendMoney->sending_currency,
                'recipient_country'  => $sendMoney->recipientCountry->name,
                'recipient_amount'   => showAmount($sendMoney->recipient_amount, currencyFormat: false),
                'recipient_currency' => $sendMoney->recipient_currency,
                'message'            => $request->message,
            ]);
            $type = 'payment';
            $notification = 'Payment request rejected successfully';
        } else {
            notify($deposit->agent, 'DEPOSIT_REJECT', [
                'method_name'       => $deposit->gatewayCurrency()->name,
                'method_currency'   => $deposit->method_currency,
                'method_amount'     => showAmount($deposit->final_amount, currencyFormat: false),
                'amount'            => showAmount($deposit->amount, currencyFormat: false),
                'charge'            => showAmount($deposit->charge, currencyFormat: false),
                'rate'              => showAmount($deposit->rate, currencyFormat: false),
                'trx'               => $deposit->trx,
                'rejection_message' => $request->message
            ]);
            $type = 'deposit';
            $notification = 'Deposit request rejected successfully';
        }

        $notify[] = ['success', $notification];
        return  to_route("admin.$type.pending")->withNotify($notify);
    }
}
