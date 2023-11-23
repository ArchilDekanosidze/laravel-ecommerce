<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Services\Auth\OTPResetPassword;
use App\Services\Auth\Traits\hasOTP;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordOTPController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;
    use hasOTP;

    public function __construct(OTPResetPassword $otp)
    {
        $this->otp = $otp;
    }

    public function showOTPForm()
    {
        return view('auth.otp.reset-password');
    }

    protected function SendTokenSuccessResponse()
    {
        return redirect()->route('auth.otp.password.code.form')->with('success', 'code sent');
    }

}
