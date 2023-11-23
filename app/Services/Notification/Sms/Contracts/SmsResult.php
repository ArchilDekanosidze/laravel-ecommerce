<?php
namespace App\Services\Notification\Sms\Contracts;

interface SmsResult
{
    const SENT_Failed = 'failed';
    const SENT_SUCCESS = 'success';
}
