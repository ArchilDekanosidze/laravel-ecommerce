<?php
namespace App\Services\Auth;

use App\Models\Otp;
use App\Models\User;
use App\Services\Auth\Traits\hasUsername;
use Illuminate\Http\Request;

class OTPAuthenticaton
{
    use hasUsername;

    const CODE_SENT = 'code.sent';
    const INVALID_CODE = 'code.invalid';
    const CODE_CONFIRMED = 'code.confirmed';

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function requestCode()
    {
        $code = Otp::generateCodeFor($this->request->username);
        $this->setSession($code);
        $code->send($this->request->username);
        return static::CODE_SENT;
    }

    protected function isValidCode()
    {
        return !$this->getToken()->isExpired() && $this->getToken()->isEqualWith($this->request->code);

    }

    protected function setSession(Otp $code)
    {
        session([
            'code_id' => $code->id,
            'username' => $code->username,
            'remember' => $this->request->remember,
        ]);
    }

    protected function forgetSession()
    {
        session()->forget(['username', 'code_id', 'remember']);
    }

    protected function getToken()
    {
        return $this->code ?? $this->code = Otp::findOrFail(session('code_id'));
    }

    protected function getUser()
    {
        return User::where('email', session('username'))->orWhere('mobile', session('username'))->first();
    }

    public function resend()
    {
        $code = Otp::generateCodeFor(session('username'));
        $this->setSession($code);
        $code->send(session('username'));
        return static::CODE_SENT;
    }

    protected function verified_at(User $user)
    {
        $username = session('username');

        if ($this->isUsernameAnMobile($username)) {
            $user->markMobileAsVerified();
            $user->save();
        }

        if ($this->isUsernameAnEmail($username)) {
            $user->markEmailAsVerified();
            $user->save();
        }
    }
}
