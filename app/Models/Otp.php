<?php

namespace App\Models;

use App\Jobs\Notification\Email\SendEmailWithMailAddress;
use App\Jobs\Notification\Sms\SendSmsWithNumber;
use App\Mail\OTPCode;
use App\Services\Notification\Sms\Contracts\SmsTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    const CODE_EXPIRY = 60; // second

    protected $guarded = ['id'];

    public static function generateCodeFor($username)
    {
        $code = Otp::where('username', $username)->delete();
        return static::create([
            'username' => $username,
            'code' => mt_rand(1000, 9999),
        ]);
    }

    public function send($username)
    {
        if ($this->isUsernameAnMobile($username)) {
            $data = [
                'type' => SmsTypes::OTP_CODE,
                'variables' => ['verificationCode' => $this->code],
            ];
            // SendSmsWithNumber::dispatch($username, $data);
        }
        if ($this->isUsernameAnEmail($username)) {
            $mailable = new OTPCode($this->code);
            // SendEmailWithMailAddress::dispatch($username, $mailable);
        }
    }

    private function isUsernameAnEmail($username)
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL);
    }

    private function isUsernameAnMobile($username)
    {
        $username = ltrim($username, '+');
        return preg_match('/[0-9]+$/', $username);
    }

    public function isExpired()
    {
        return $this->created_at->diffInSeconds(now()) > static::CODE_EXPIRY;
    }

    public function isEqualWith(string $code)
    {
        return $this->code == $code;
    }
}
