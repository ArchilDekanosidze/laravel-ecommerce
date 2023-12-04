<?php

namespace App\Services\Auth\Traits;

use App\Rules\CodeRule;
use App\Services\Auth\Traits\hasUsername;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait hasOTP
{
    protected $otp;
    use hasUsername;

    public function showOTPForm()
    {
        return view('auth.otp.login');
    }

    public function sendToken(Request $request)
    {
        $this->validateUserNameForm($request);

        if (!$this->CheckUserNameCondition($request)) {
            return $this->SendCheckUserNameConditionFailedResponse();
        }
        $response = $this->otp->requestCode();
        return $response == $this->otp::CODE_SENT
            ? $this->SendTokenSuccessResponse()
            : $this->SendTokenFailedResponse();
    }

    public function showEnterCodeForm()
    {
        return view('auth.otp.login-enter-code');
    }

    public function confirmCode(Request $request)
    {
        $this->validateCodeForm($request);
        $response = $this->otp->confirmCode();
        return $response == $this->otp::CODE_CONFIRMED
            ? $this->SendConfirmCodeSuccessResponse()
            : $this->SendConfirmCodeFailedResponse();
    }

    public function resend()
    {
        $this->otp->resend();
        return back()->with('success', __('auth.Code Resent'));
    }

    protected function validateUserNameForm(Request $request)
    {
        $request->validate(
            [
                'username' => ['required'],
            ]
        );
    }

    public function CheckUserNameCondition($request)
    {
        return $this->isUserExists($request->username);
    }

    protected function validateCodeForm(Request $request)
    {
        $request->validate(
            [
                'code' => new CodeRule(),
            ]
        );
    }

    public function SendCheckUserNameConditionFailedResponse()
    {
        return $this->SendCredentialsFailedResponse();
    }

    protected function SendTokenSuccessResponse()
    {
        return redirect()->route('auth.otp.login.code.form')->with('success', __('auth.Code Sent'));
    }

    protected function SendTokenFailedResponse()
    {
        return back()->withErrors(['cantSendCode' => __('auth.cant Send Code')]);
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    protected function SendConfirmCodeFailedResponse()
    {
        return back()->withErrors(['invalidCode' => __('validation.code is invalid.')]);
    }
}
