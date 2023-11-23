<?php
namespace App\Services\Notification\Sms;

use App\Models\User;
use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Exceptions\UserDoesNotHaveNumber;

class SmsProvider
{
    private $phone_number_column_name = 'mobile';
    private $user;
    private $data;

    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function send()
    {
        $this->havePhoneNumber();
        $phone_number = $this->user->{$this->phone_number_column_name};
        $smsProvider = app()->makeWith(SmsSender::class, ['phone_numbers' => $phone_number, 'data' => $this->data]);
        $result = $smsProvider->send();
        return $result;
    }

    private function havePhoneNumber()
    {
        if (is_null($this->user->{$this->phone_number_column_name})) {
            throw new UserDoesNotHaveNumber();
        }
    }

}
