<?php
namespace App\Services\Auth;

use App\Services\Auth\OTPAuthenticaton;
use Illuminate\Support\Facades\Auth;

class OTPProfileMobile extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $user = $this->getUser();
        $user->mobile = session('username');
        $user->mobile_verified_at = now();
        $user->save();
        return static::CODE_CONFIRMED;
    }

    protected function getUser()
    {
        return Auth::user();
    }
}
