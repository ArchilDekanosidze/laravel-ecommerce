<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Services\Auth\OTPRegister;
use App\Services\Auth\Traits\hasOTP;

class RegisterOTPController extends Controller
{
    use hasOTP;

    public function __construct(OTPRegister $otp)
    {
        $this->otp = $otp;
    }

    public function showOTPForm()
    {
        return view('auth.otp.register');
    }

    public function showEnterCodeForm()
    {
        return view('auth.otp.register-enter-code');
    }

    public function CheckUserNameCondition($request)
    {
        return !$this->isUserExists($request->username) && $this->isUsernameValid($request->username);
    }

    public function SendCheckUserNameConditionFailedResponse()
    {
        $errorText = 'wrong username(username already exist or is invalid)';
        return back()->withErrors(['Credentials' => $errorText]);
    }

    protected function SendTokenSuccessResponse()
    {
        return redirect()->route('auth.otp.register.code.form')->with('success', 'code sent');
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->route('customer.home');
    }

}
