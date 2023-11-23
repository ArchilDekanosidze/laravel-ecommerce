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

    public function CheckUserNameCondition($request)
    {
        return $this->isUserExists($request->username);
    }

    public function SendCheckUserNameConditionFailedResponse()
    {
        return $this->SendCredentialsFailedResponse();
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

    protected function validateUserNameForm(Request $request)
    {
        $request->validate(
            [
                'username' => ['required'],
            ]
        );
    }
    protected function validateCodeForm(Request $request)
    {
        $request->validate(
            [
                'code' => new CodeRule(),
            ]
        );
    }

    public function resend()
    {
        $this->otp->resend();
        return back()->with('success', __('public.Code Resent'));
    }

    protected function SendTokenSuccessResponse()
    {
        return redirect()->route('auth.otp.login.code.form')->with('success', 'code sent');
    }

    protected function SendTokenFailedResponse()
    {
        return back()->withErrors(['cantSendCode' => 'cant Send Code']);
    }

    protected function SendConfirmCodeSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    protected function SendConfirmCodeFailedResponse()
    {
        return back()->withErrors(['invalidCode' => 'code is invalid']);
    }
}
