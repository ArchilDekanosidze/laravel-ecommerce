<?php
namespace App\Services\Notification\Sms\Providers\FarazSms\Pattern;

use App\Services\Notification\Sms\Providers\FarazSms\Pattern\Contracts\PatternInterface;

class Patternkbsvo7sksbk0mp1 implements PatternInterface
{
    private $variables;

    public function __construct($variables)
    {
        $this->variables = $variables;
    }

    public function createInputData()
    {
        return array("verification-code" => $this->variables['verificationCode']);
    }
}
