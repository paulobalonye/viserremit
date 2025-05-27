<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\Status;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $username;

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->findUsername();
    }

    public function login(Request $request)
    {
        if ($request->is_web) {
            if (!verifyCaptcha()) {
                $notify[] = 'Invalid captcha provided';
                return responseError('captcha_error', $notify);
            }
        }

        $validator = $this->validateLogin($request);
        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $credentials = request([$this->username, 'password']);
        if (!Auth::attempt($credentials)) {
            $notify[] = 'Unauthorized user';
            return responseError('unauthorized_user', $notify);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('auth_token', ['user'])->plainTextToken;
        $this->authenticated($request, $user);
        $notify[] = 'Login Successful';
        return responseSuccess('login_success', $notify, [
            'user' => auth()->user(),
            'kyc_data' => auth()->user()->kyc_data,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer'
        ]);
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin(Request $request)
    {
        $validationRule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $validationRule);
        return $validate;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        $notify[] = 'Logout Successful';
        return responseSuccess('logout_success', $notify);
    }

    public function authenticated(Request $request, $user)
    {
        $user->tv = $user->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $user->save();
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;
        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
    }

    public function checkToken(Request $request)
    {
        $validationRule = [
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        $exists = PersonalAccessToken::where('token', hash('sha256', $request->token))->exists();

        if ($exists) {
            $notify[] = 'Token exists';
            return responseSuccess('token_exists', $notify);
        }

        $notify[] = 'Token doesn\'t exists';
        return responseError('token_not_exists', $notify);
    }
}
