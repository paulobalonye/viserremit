<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Models\Agent;
use App\Models\AgentPasswordReset;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $pageTitle = 'Account Recovery';
        return view('agent.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $fieldType = $this->findFieldType();
        $agent = Agent::where($fieldType, $request->value)->first();

        if (!$agent) {
            $notify[] = ['error', 'The account could not be found'];
            return back()->withNotify($notify);
        }

        AgentPasswordReset::where('email', $agent->email)->delete();
        $code = verificationCode(6);
        $agentPasswordReset = new AgentPasswordReset();
        $agentPasswordReset->email = $agent->email;
        $agentPasswordReset->token = $code;
        $agentPasswordReset->status = 0;
        $agentPasswordReset->created_at = Carbon::now();
        $agentPasswordReset->save();

        $agentIpInfo = getIpInfo();
        $agentBrowser = osBrowser();
        notify($agent, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => $agentBrowser['os_platform'],
            'browser' => $agentBrowser['browser'],
            'ip' => $agentIpInfo['ip'],
            'time' => $agentIpInfo['time']
        ], ['email'], false);

        $email = $agent->email;
        session()->put('pass_res_mail', $email);

        $notify[] = ['success', 'Password reset email sent successfully'];
        return to_route('agent.password.code.verify')->withNotify($notify);
    }

    public function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify(Request $request)
    {
        $pageTitle = 'Verify Code';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error', 'Oops! session expired'];
            return to_route('agent.password.reset')->withNotify($notify);
        }
        return view('agent.auth.passwords.code_verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);
        if (AgentPasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('agent.password.request')->withNotify($notify);
        }
        session()->flash('fpass_email', $request->email);
        $notify[] = ['success', 'You can change your password'];
        return to_route('agent.password.reset.form', $code)->withNotify($notify);
    }
}
