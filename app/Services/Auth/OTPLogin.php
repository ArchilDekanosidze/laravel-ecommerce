<?php
namespace App\Services\Auth;

use App\Services\Auth\OTPAuthenticaton;
use Illuminate\Support\Facades\Auth;

class OTPLogin extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $user = $this->getUser();
        $this->verified_at($user);
        Auth::login($user, session('remember'));
        $this->forgetSession();
        return static::CODE_CONFIRMED;
    }

}
