<?php

namespace App\Services\Notification\Sms\Contracts;

interface SmsSenderInterface
{
    public function setMobiles($mobiles);
    public function setData(array $data);
    public function send();
}
