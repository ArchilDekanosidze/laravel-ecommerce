<?php
namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\OTPAuthenticaton;
use Illuminate\Support\Facades\Auth;

class OTPRegister extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $user = new User();
        if ($this->isUsernameAnEmail(session('username'))) {
            $user->email = session('username');
            $user->markEmailAsVerified();
        }
        if ($this->isUsernameAnMobile(session('username'))) {
            $user->mobile = session('username');
            $user->markMobileAsVerified();
        }
        $user->save();
        Auth::login($user, session('remember'));
        $this->forgetSession();
        return static::CODE_CONFIRMED;
    }

}
