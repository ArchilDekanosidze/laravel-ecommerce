<?php
namespace App\Services\Auth\Traits;

use App\Models\LoginToken;
use Illuminate\Support\Str;

trait MagicallyAuthenticable
{
    public function magicToken()
    {
        return $this->hasOne(LoginToken::class);
    }
    public function createMagicToken()
    {
        $this->magicToken()->delete();
        return $this->magicToken()->create([
            'token' => Str::random(50),
        ]);
    }
}
