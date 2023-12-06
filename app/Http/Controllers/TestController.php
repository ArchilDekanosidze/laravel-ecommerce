<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Jobs\Notification\Sms\SendSms;
use App\Jobs\Notification\Sms\SendSmsToMultipleUser;
use App\Services\Notification\Sms\Contracts\SmsTypes;
use App\Jobs\Notification\Email\SendEmailWithMailAddress;
use App\Jobs\Notification\Sms\SendSmsWithNumber;

class TestController extends Controller
{
    // test git
    public function tlogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function tlogin(Request $request)
    {
        Auth::loginUsingId(6);
    }
    protected function guard()
    {
        return Auth::guard();
    }
    public function testEmail()
    {
        $users = User::find([1, 6]);
        $mailable = new UserRegistered();
        // SendEmail::dispatch($user, $mailable);
        $users = User::find(1);
        SendEmailWithMailAddress::dispatch(['h.mirshekar69@gmail.com', 'dekanosidzearchil@gmail.com'], $mailable);
        // $SendEmail->send(['h.mirshekar69@gmail.com', 'dekanosidzearchil@gmail.com'], $mailable);
    }

    public function testSms()
    {
        $users = User::find([22, 24]);
        $data = [
            'type' => SmsTypes::OTP_CODE,
            'variables' => ['verificationCode' => 123],
        ];
        SendSmsToMultipleUser::dispatch($users, $data);
    }

    public function tredis()
    {
        Redis::rpush('list6', 'hamed', 'ali', 'reza', 'nafas', 'mahshid');
        Redis::lset('list6', 2, 'maryam');
        dump(Redis::lrange('list6', 0, 10));
    }

    public function tMongo()
    {
        dd(phpinfo());
    }
}
