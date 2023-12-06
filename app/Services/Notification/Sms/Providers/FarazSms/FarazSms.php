<?php

namespace App\Services\Notification\Sms\Providers\FarazSms;

use App\Services\Notification\Sms\Contracts\SmsResult;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Notification\Sms\Providers\FarazSms\Constants\SmsTypesFaraz;

class FarazSms implements SmsSenderInterface
{
    private $mobiles;
    private $data;
    private $input_data;
    private $result;

    public function __construct()
    {
        $this->result = array();
    }

    public function setMobiles($mobiles)
    {
        $this->mobiles = is_array($mobiles) ? $mobiles : array($mobiles);
    }
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function send()
    {
        foreach ($this->mobiles as $to) {
            $url = $this->prepareUrlForSms($to);
            $handler = curl_init($url);
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($handler, CURLOPT_POSTFIELDS, $this->input_data);
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handler);
            $this->addResponseToResult($response);
            curl_close($handler);
        }
        $this->SortResult();
        return $this->result;
    }

    private function prepareUrlForSms($to)
    {
        $username = config('services.smsFaraz.auth.uname');
        $password = config('services.smsFaraz.auth.pass');
        $from = config('services.smsFaraz.auth.from');
        $smsType = $this->data['type'];
        $patternCode = SmsTypesFaraz::toPatternCode($smsType);
        $classPath = SmsTypesFaraz::toClass($smsType);
        $smsFarazClass = new $classPath($this->data['variables']);
        $this->input_data = $smsFarazClass->createInputData();
        $baseUri = config('services.smsFaraz.baseUri');
        $url = $baseUri . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($this->input_data)) . "&pattern_code=$patternCode";
        return $url;
    }

    private function addResponseToResult($response)
    {
        $response = json_decode($response);
        if (gettype($response) == 'integer') {
            $this->result[] = [
                'status' => SmsResult::SENT_SUCCESS,
                'code' => $response,
                'message' => 'Ok'
            ];
        } else {
            $this->result[] = [
                'status' => SmsResult::SENT_Failed,
                'code' => $response[0],
                'message' => $response[1]
            ];
        }
    }

    private function SortResult()
    {
        if (count($this->result) == 1) {
            $this->result = $this->result[0];
        }
    }
}
