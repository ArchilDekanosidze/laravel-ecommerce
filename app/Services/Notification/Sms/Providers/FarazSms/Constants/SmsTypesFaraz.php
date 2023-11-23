<?php
namespace App\Services\Notification\Sms\Providers\FarazSms\Constants;

use App\Services\Notification\Sms\Contracts\SmsTypes;

class SmsTypesFaraz implements SmsTypes
{
    public static function toPatternCode($type)
    {
        try {
            return [
                self::VERIFICATION_CODE => 'kbsvo7sksbk0mp1',
                self::VERIFICATION_CODE_NAME => 'm4hro3odj6x9k2r',
                self::OTP_CODE => 'kbsvo7sksbk0mp1',
            ][$type];
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException('Patern Type  does not exist');
        }
    }
    public static function toClass($type)
    {
        $fileName = 'Pattern' . self::toPatternCode($type);
        $paternPath = __NAMESPACE__;
        $pos = strrpos($paternPath, '\\');
        if (!$pos) {
            $pos = strrpos($paternPath, '/');
        }
        $paternPath = substr($paternPath, 0, $pos + 1);
        $paternPath = $paternPath . 'Pattern\\' . $fileName;
        if (!class_exists($paternPath)) {
            throw new \InvalidArgumentException('class does not exist');
        }
        return $paternPath;
        // try {
        //     return [
        //         self::PANEL_SHARJ => Pattern7duic3llh7sovjz::class,
        //         self::FACTOR => Patternf6jhyw2aye64nwb::class,
        //         self::VERIFICATION_CODE => Patterne9ssnpjkcqbtjlt::class,
        //     ][$type];
        // } catch (\Throwable $th) {
        //     throw new \InvalidArgumentException('class does not exist');
        // }
    }
}
