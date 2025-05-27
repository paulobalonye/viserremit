<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\AgentPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (AgentPasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return to_route('agent.password.reset')->withNotify($notify);
        }

        $pageTitle = "Account Recovery";
        return view('agent.auth.passwords.reset', compact('pageTitle', 'email', 'token'));
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules());

        $reset = AgentPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid verification code'];
            return to_route('agent.login')->withNotify($notify);
        }
        $user = Agent::where('email', $reset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        notify($user, 'PASS_RESET_DONE', [
            'operating_system' => $userBrowser['os_platform'],
            'browser' => $userBrowser['browser'],
            'ip' => $userIpInfo['ip'],
            'time' => $userIpInfo['time']
        ], ['email'], false);

        $notify[] = ['success', 'Password changed successfully'];
        return to_route('agent.login')->withNotify($notify);
    }

    protected function rules()
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', $passwordValidation],
        ];
    }
}
