<?php

namespace App\Services\Notification\Sms;

use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Notification\Sms\Contracts\SmsProviderInterface;

class SmsWithNumberProvider implements SmsProviderInterface
{
    private $phone_numbers;
    private $data;
    private $smsSender;

    public function __construct(SmsSenderInterface $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function setPhoneNumber($phone_numbers)
    {
        $this->phone_numbers = $phone_numbers;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function send()
    {
        $this->smsSender->setMobiles($this->phone_numbers);
        $this->smsSender->setData($this->data);
        $result = $this->smsSender->send();
        return $result;
    }
}
