<?php
namespace App\Services\Auth;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagicAuthentication
{
    const INVALID_TOKEN = 'token.invalid';
    const AUTHENTICATED = 'authenticated';

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestLink()
    {
        $user = $this->getUser();
        $user->createMagicToken()->send(['remember' => $this->request->has('remember')]);
    }

    public function getUser()
    {
        return User::where('email', $this->request->email)->firstOrFail();
    }

    public function authenticate(LoginToken $token)
    {
        $token->delete();
        if ($token->isExpired()) {
            return self::INVALID_TOKEN;
        }
        Auth::login($token->user, $this->request->query('remember'));
        return self::AUTHENTICATED;

    }

}
