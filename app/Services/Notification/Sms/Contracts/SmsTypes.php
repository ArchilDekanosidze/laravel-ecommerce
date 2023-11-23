<?php
namespace App\Services\Notification\Sms\Contracts;

interface SmsTypes
{
    const VERIFICATION_CODE = 1;
    const VERIFICATION_CODE_NAME = 2;
    const TWO_FACTOR_ACTIVATION_CODE = 3;
    const OTP_CODE = 4;

}
