<?php
namespace App\Services\Notification\Sms;

use App\Services\Notification\Sms\Contracts\SmsSender;

class SmsWithNumberProvider
{
    private $phone_numbers;
    private $data;

    public function __construct($phone_numbers, $data)
    {
        $this->phone_numbers = $phone_numbers;
        $this->data = $data;
    }

    public function send()
    {
        $smsProvider = app()->makeWith(SmsSender::class, ['phone_numbers' => $this->phone_numbers, 'data' => $this->data]);
        $result = $smsProvider->send();
        return $result;
    }

}
