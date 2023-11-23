<?php
namespace App\Services\Notification\Sms\Providers\MeliPayamak\Constants;

use App\Services\Notification\Sms\Contracts\SmsTypes;

class SmsTypesMeliPayamak implements SmsTypes
{
    public static function toPatternCode($type)
    {
        try {
            return [
                self::VERIFICATION_CODE => '164887',
                self::VERIFICATION_CODE_NAME => '164904',
                self::TWO_FACTOR_ACTIVATION_CODE => '164887',
                self::OTP_CODE => '164887',
            ][$type];
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException('Patern Type  does not exist');
        }
    }
}
