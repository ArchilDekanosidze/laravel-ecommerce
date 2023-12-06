<?php

namespace App\Services\Notification\Sms;

use App\Models\User;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Notification\Sms\Contracts\SmsProviderInterface;
use App\Services\Notification\Sms\Exceptions\UserDoesNotHaveNumber;

class SmsProvider implements SmsProviderInterface
{
    private $phone_number_column_name = 'mobile';
    private $user;
    private $data;
    private $smsSender;

    public function __construct(SmsSenderInterface $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function send()
    {
        $this->havePhoneNumber();
        $phone_number = $this->user->{$this->phone_number_column_name};
        $this->smsSender->setMobiles($phone_number);
        $this->smsSender->setData($this->data);
        $result = $this->smsSender->send();
        return $result;
    }

    private function havePhoneNumber()
    {
        if (is_null($this->user->{$this->phone_number_column_name})) {
            throw new UserDoesNotHaveNumber();
        }
    }
}
