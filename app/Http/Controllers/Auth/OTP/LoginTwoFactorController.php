<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Services\Auth\OTPLoginTwoFactor;
use App\Services\Auth\Traits\hasOTP;

class LoginTwoFactorController extends Controller
{
    use hasOTP;

    protected $otp;

    public function __construct(OTPLoginTwoFactor $otp)
    {
        $this->middleware('guest')->except('resend');
        $this->otp = $otp;
    }

    public function showEnterCodeForm()
    {
        return view('auth.otp.login-two-factor-enter-code');
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }
}
