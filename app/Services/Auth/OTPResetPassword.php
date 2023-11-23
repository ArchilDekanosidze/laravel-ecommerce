<?php
namespace App\Services\Auth;

use App\Services\Auth\OTPAuthenticaton;
use Illuminate\Support\Facades\Hash;

class OTPResetPassword extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $user = $this->getUser();
        $this->verified_at($user);
        $this->resetPassword($user, $this->request->password);
        $this->forgetSession();
        return static::CODE_CONFIRMED;
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }

}
