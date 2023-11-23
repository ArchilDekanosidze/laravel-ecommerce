<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\PasswordRule;
use App\Services\Auth\OTPResetPassword;
use App\Services\Auth\Traits\hasOTP;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordOTPController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */
    use ResetsPasswords;
    use hasOTP;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(OTPResetPassword $otp)
    {
        $this->otp = $otp;
    }

    public function showEnterCodeForm(Request $request)
    {
        return view('auth.otp.reset-password-enter-code');
    }

    protected function validateCodeForm($request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['confirmed', new PasswordRule()],
        ]);
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->route('auth.login.form');
    }

}
