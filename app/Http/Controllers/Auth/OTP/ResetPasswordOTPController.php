<?php

namespace App\Http\Controllers\Auth\OTP;

use App\Rules\CodeRule;
use App\Rules\PasswordRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\Traits\hasOTP;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\OTPResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

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
        $this->middleware('guest');
    }

    public function showEnterCodeForm(Request $request)
    {
        return view('auth.otp.reset-password-enter-code');
    }

    protected function validateCodeForm($request)
    {
        $request->validate([
            'code' => new CodeRule(),
            'username' => ['required'],
            'password' => ['confirmed', new PasswordRule()],
        ]);
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->route('auth.login.form');
    }

}
