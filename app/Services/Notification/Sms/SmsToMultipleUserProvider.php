<?php
namespace App\Services\Notification\Sms;

use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Exceptions\SomeUsersDoNotHaveNumber;

class SmsToMultipleUserProvider
{
    private $phone_number_column_name = 'mobile';
    private $phone_numbers;
    private $users;
    private $data;

    public function __construct($users, array $data)
    {
        $this->phone_numbers = array();
        $this->users = $users;
        $this->data = $data;
    }

    public function send()
    {
        $this->havePhoneNumber();
        $this->CreateArrayNumber();
        $smsProvider = app()->makeWith(SmsSender::class, ['phone_numbers' => $this->phone_numbers, 'data' => $this->data]);
        $result = $smsProvider->send();
        return $result;

    }

    private function havePhoneNumber()
    {
        foreach ($this->users as $user) {
            if (is_null($user->{$this->phone_number_column_name})) {
                throw new SomeUsersDoNotHaveNumber();
            }
        }
    }

    private function CreateArrayNumber()
    {
        foreach ($this->users as $user) {
            $mobile = $user->{$this->phone_number_column_name};
            array_push($this->phone_numbers, $mobile);
        }
    }

}
