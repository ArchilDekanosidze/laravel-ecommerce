<?php

namespace App\Services\Notification\Sms\Contracts;

use App\Services\Notification\Sms\Contracts\SmsSenderInterface;

interface SmsProviderInterface
{
    public function __construct(SmsSenderInterface $smsSender);
    public function setData($data);
    public function send();
}
