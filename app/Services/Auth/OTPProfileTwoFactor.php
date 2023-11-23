<?php
namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\OTPAuthenticaton;

class OTPProfileTwoFactor extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $this->getUser()->activateTwoFactor();
        $this->forgetSession();
        return static::CODE_CONFIRMED;
    }

    public function deactivate(User $user)
    {
        return $user->deactivateTwoFactor();
    }

}
