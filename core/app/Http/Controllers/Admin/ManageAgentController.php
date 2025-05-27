<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agent;
use App\Models\Country;
use App\Models\Deposit;
use App\Constants\Status;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\NotificationLog;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ManageAgentController extends Controller
{
    public $pageTitle;
    public function add()
    {
        $pageTitle   = 'Add New Agent';
        $countries   = Country::all();
        return view('admin.agents.add', compact('pageTitle', 'countries'));
    }

    public function store(Request $request)
    {
        $general = gs();
        $agent   = new Agent();
        $this->validation($request);

        $exist = Agent::where('mobile', $request->mobile_code . $request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        $country = Country::find($request->country);
        if (!$country) {
            $notify[] = ['error', 'Country not exist'];
            return back()->withNotify($notify)->withInput();
        }

        $agent->username = $request->username;
        $agent->password = Hash::make($request->password);

        $agent->status = Status::ENABLE;
        $agent->kv     = $general->kv ? Status::KYC_UNVERIFIED : Status::KYC_VERIFIED;
        $agent->ts     = Status::DISABLE;
        $agent->tv     = Status::ENABLE;

        $agent = $this->saveAgent($request, $country, $agent);

        notify($agent, 'AGENT_ACCOUNT_CREATED', [
            'username'  => $request->username,
            'password'  => $request->password,
            'login_url' => route('agent.login'),
        ]);

        $notify[] = ['success', 'Agent added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);
        $this->validation($request, $agent);

        if (!$request->kv) {
            $agent->kv       = Status::KYC_UNVERIFIED;
            $agent->kyc_data = null;
        } else {
            $agent->kv = Status::KYC_VERIFIED;
        }

        $country = Country::find($request->country);
        if (!$country) {
            $notify[] = ['error', 'Country not exist'];
            return back()->withNotify($notify)->withInput();
        }

        $this->saveAgent($request, $country, $agent);

        $notify[] = ['success', 'Agent details updated successfully'];
        return back()->withNotify($notify);
    }

    public function validation($request, $agent = null)
    {
        $passwordValidation = Password::min(6);
        $rules = [
            'firstname' => 'required|string|max:40',
            'lastname'  => 'required|string|max:40',
            'country'   => 'required|integer|gt:0',
            'mobile'    => 'required|regex:/^([0-9]*)$/',
            'email'     => 'required|email|string|max:40|unique:agents,email,' . @$agent->id,
        ];
        if (!$agent) {
            $rules['password'] = ['required', 'confirmed', $passwordValidation];
            $rules['username'] = 'required|alpha_num|unique:agents|min:6';
        }
        $request->validate($rules);
    }

    public function saveAgent($request, $country, $agent)
    {
        $agent->country_id   = $country->id;
        $agent->mobile       = $country->dial_code . $request->mobile;
        $agent->country_code = $country->country_code;
        $agent->firstname    = $request->firstname;
        $agent->lastname     = $request->lastname;
        $agent->email        = $request->email;
        $agent->state        = $request->state;
        $agent->city         = $request->city;
        $agent->zip          = $request->zip;
        $agent->address      = $request->address;
        $agent->save();
        return $agent;
    }

    public function allAgents()
    {
        $this->pageTitle = 'All Agents';
        return $this->agentData();
    }

    public function activeAgents()
    {
        $this->pageTitle = 'Active Agents';
        return $this->agentData('active');
    }

    public function bannedAgents()
    {
        $this->pageTitle = 'Banned Agents';
        return $this->agentData('banned');
    }

    public function kycUnverifiedAgents()
    {
        $this->pageTitle = 'KYC Unverified Agents';
        return $this->agentData('kycUnverified');
    }

    public function kycPendingAgents()
    {
        $this->pageTitle = 'KYC Unverified Agents';
        return $this->agentData('kycPending');
    }

    public function agentsWithBalance()
    {
        $this->pageTitle = 'Agents with Balance';
        return $this->agentData('withBalance');
    }

    protected function agentData($scope = null)
    {
        if ($scope) {
            $agents = Agent::$scope();
        } else {
            $agents = Agent::query();
        }

        $pageTitle = $this->pageTitle;
        $agents = $agents->searchable(['username', 'email'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.agents.list', compact('pageTitle', 'agents'));
    }

    public function detail($id)
    {
        $agent     = Agent::findOrFail($id);
        $pageTitle = 'Agent Detail - ' . $agent->username;

        $totalDeposit     = Deposit::where('agent_id', $agent->id)->where('status', 1)->sum('amount');
        $totalWithdrawals = Withdrawal::where('agent_id', $agent->id)->where('status', 1)->sum('amount');
        $totalTransaction = Transaction::where('agent_id', $agent->id)->count();
        $countries        = Country::all();
        return view('admin.agents.detail', compact('pageTitle', 'agent', 'totalDeposit', 'totalWithdrawals', 'totalTransaction', 'countries'));
    }

    public function kycDetails($id)
    {
        $pageTitle = 'KYC Details';
        $agent     = Agent::findOrFail($id);
        return view('admin.agents.kyc_detail', compact('pageTitle', 'agent'));
    }

    public function kycApprove($id)
    {
        $agent     = Agent::findOrFail($id);
        $agent->kv = Status::KYC_VERIFIED;
        $agent->save();

        notify($agent, 'KYC_APPROVE', []);

        $notify[] = ['success', 'KYC approved successfully'];
        return to_route('admin.agents.kyc.pending')->withNotify($notify);
    }

    public function kycReject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required'
        ]);
        $agent = Agent::findOrFail($id);
        foreach ($agent->kyc_data as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $agent->kv                   = Status::KYC_UNVERIFIED;
        $agent->kyc_rejection_reason = $request->reason;
        $agent->kyc_data             = null;
        $agent->save();

        notify($agent, 'KYC_REJECT', []);

        $notify[] = ['success', 'KYC rejected successfully'];
        return to_route('admin.agents.kyc.pending')->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act'    => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $agent   = Agent::findOrFail($id);
        $amount  = $request->amount;
        $trx     = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $agent->balance += $amount;
            $transaction->trx_type = '+';
            $transaction->remark   = 'balance_add';
            $notifyTemplate        = 'BAL_ADD';
            $notify[] = ['success', 'Balance added successfully'];
        } else {
            if ($amount > $agent->balance) {
                $notify[] = ['error', $agent->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }
            $agent->balance        -= $amount;
            $transaction->trx_type  = '-';
            $transaction->remark    = 'balance_subtract';
            $notifyTemplate         = 'BAL_SUB';
            $notify[] = ['success', 'Balance subtracted successfully'];
        }
        $agent->save();

        $transaction->agent_id     = $agent->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $agent->balance;
        $transaction->charge       = 0;
        $transaction->trx          = $trx;
        $transaction->details      = $request->remark;
        $transaction->save();

        notify($agent, $notifyTemplate, [
            'trx'          => $trx,
            'amount'       => showAmount($amount, currencyFormat: false),
            'remark'       => $request->remark,
            'post_balance' => showAmount($agent->balance, currencyFormat: false)
        ]);

        return back()->withNotify($notify);
    }

    public function login($id)
    {
        auth()->logout();
        auth()->guard('agent')->loginUsingId($id);
        return to_route('agent.dashboard');
    }

    public function status(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);
        if ($agent->status == Status::ENABLE) {

            $request->validate([
                'reason' => 'required|string|max:255'
            ]);

            $agent->status     = Status::DISABLE;
            $agent->ban_reason = $request->reason;
            $notify[]          = ['success', 'Agent banned successfully'];
        } else {
            $agent->status     = Status::ENABLE;
            $agent->ban_reason = null;
            $notify[]          = ['success', 'Agent unbanned successfully'];
        }

        $agent->save();
        return back()->withNotify($notify);
    }

    public function showNotificationSingleForm($id)
    {
        $agent   = Agent::findOrFail($id);
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.agents.detail', $agent->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $agent->username;
        return view('admin.agents.notification_single', compact('pageTitle', 'agent'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);
        $agent = Agent::findOrFail($id);
        notify($agent, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToUser = Agent::notifyToUser('agent');
        $agents        = Agent::active()->count();
        $pageTitle    = 'Notification to Verified Agent';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.agents.notification_all', compact('pageTitle', 'agents', 'notifyToUser'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                          => 'required|in:email,sms,push',
            'message'                      => 'required',
            'subject'                      => 'required_if:via,email,push',
            'start'                        => 'required|integer|gte:1',
            'batch'                        => 'required|integer|gte:1',
            'being_sent_to'                => 'required',
            'cooling_time'                 => 'required|integer|gte:1',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'               => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                        => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'               => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        if ($request->being_sent_to == 'selectedUsers') {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['user' => session()->get('SEND_NOTIFICATION')['user']]);
            } else {
                if (!$request->user || !is_array($request->user) || empty($request->user)) {
                    $notify[] = ['error', "Ensure that the user field is populated when sending an email to the designated user group"];
                    return back()->withNotify($notify);
                }
            }
        }
        $scope          = $request->being_sent_to;
        $userQuery      = Agent::oldest()->active()->$scope();

        if (session()->has("SEND_NOTIFICATION")) {
            $totalUserCount = session('SEND_NOTIFICATION')['total_user'];
        } else {
            $totalUserCount = (clone $userQuery)->count() - ($request->start - 1);
        }

        if ($totalUserCount <= 0) {
            $notify[] = ['error', "Notification recipients were not found among the selected user base."];
            return back()->withNotify($notify);
        }

        $imageUrl = null;

        if ($request->via == 'push' && $request->hasFile('image')) {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['image' => session()->get('SEND_NOTIFICATION')['image']]);
            }
            if ($request->hasFile("image")) {
                $imageUrl = fileUploader($request->image, getFilePath('push'));
            }
        }

        $users = (clone $userQuery)->skip($request->start - 1)->limit($request->batch)->get();

        foreach ($users as $user) {
            notify($user, 'DEFAULT', [
                'subject' => $request->subject,
                'message' => $request->message,
            ], [$request->via], pushImage: $imageUrl);
        }

        return $this->sessionForNotification($totalUserCount, $request);
    }

    private function sessionForNotification($totalUserCount, $request)
    {
        if (session()->has('SEND_NOTIFICATION')) {
            $sessionData                = session("SEND_NOTIFICATION");
            $sessionData['total_sent'] += $sessionData['batch'];
        } else {
            $sessionData               = $request->except('_token');
            $sessionData['total_sent'] = $request->batch;
            $sessionData['total_user'] = $totalUserCount;
        }

        $sessionData['start'] = $sessionData['total_sent'] + 1;

        if ($sessionData['total_sent'] >= $totalUserCount) {
            session()->forget("SEND_NOTIFICATION");
            $message = ucfirst($request->via) . " notifications were sent successfully";
            $url     = route("admin.agents.notification.all");
        } else {
            session()->put('SEND_NOTIFICATION', $sessionData);
            $message = $sessionData['total_sent'] . " " . $sessionData['via'] . "  notifications were sent successfully";
            $url     = route("admin.agents.notification.all") . "?email_sent=yes";
        }
        $notify[] = ['success', $message];
        return redirect($url)->withNotify($notify);
    }

    public function notificationLog($id)
    {
        $agent     = Agent::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $agent->username;
        $logs      = NotificationLog::where('agent_id', $id)->with('user', 'agent')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'agent'));
    }
}
