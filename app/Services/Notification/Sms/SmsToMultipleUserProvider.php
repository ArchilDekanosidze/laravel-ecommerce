<?php

namespace App\Services\Notification\Sms;

use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Notification\Sms\Contracts\SmsProviderInterface;
use App\Services\Notification\Sms\Exceptions\SomeUsersDoNotHaveNumber;

class SmsToMultipleUserProvider implements SmsProviderInterface
{
    private $phone_number_column_name = 'mobile';
    private $phone_numbers;
    private $users;
    private $data;
    private $smsSender;


    public function __construct(SmsSenderInterface $smsSender)
    {
        $this->phone_numbers = array();
        $this->smsSender = $smsSender;
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function send()
    {
        $this->havePhoneNumber();
        $this->CreateArrayNumber();
        $this->smsSender->setMobiles($this->phone_numbers);
        $this->smsSender->setData($this->data);
        $result = $this->smsSender->send();
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
