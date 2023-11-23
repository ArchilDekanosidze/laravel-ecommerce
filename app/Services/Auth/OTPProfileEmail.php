<?php
namespace App\Services\Auth;

use App\Services\Auth\OTPAuthenticaton;
use Illuminate\Support\Facades\Auth;

class OTPProfileEmail extends OTPAuthenticaton
{
    public function confirmCode()
    {
        if (!$this->isValidCode()) {
            return static::INVALID_CODE;
        }
        $this->getToken()->delete();
        $user = $this->getUser();
        $user->email = session('username');
        $user->email_verified_at = now();
        $user->save();
        return static::CODE_CONFIRMED;
    }
    protected function getUser()
    {
        return Auth::user();
    }
}
