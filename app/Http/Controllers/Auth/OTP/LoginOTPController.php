<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Services\Auth\OTPLogin;
use App\Services\Auth\Traits\hasOTP;

class LoginOTPController extends Controller
{
    use hasOTP;
    public function __construct(OTPLogin $otp)
    {
        $this->otp = $otp;
        $this->middleware('guest');
    }
}
