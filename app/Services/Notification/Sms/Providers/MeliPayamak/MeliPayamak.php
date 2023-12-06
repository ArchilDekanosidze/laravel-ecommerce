<?php

namespace App\Services\Notification\Sms\Providers\MeliPayamak;

use App\Services\Notification\Sms\Contracts\SmsResult;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;
use App\Services\Notification\Sms\Providers\MeliPayamak\Constants\SmsTypesMeliPayamak;

class MeliPayamak implements SmsSenderInterface
{
    private $mobiles;
    private $variables;
    private $patternCode;
    private $result;

    public function __construct($mobiles, array $data)
    {
        $this->result = array();
    }

    public function setMobiles($mobiles)
    {
        $this->mobiles = is_array($mobiles) ? $mobiles : array($mobiles);
    }

    public function setData(array $data)
    {
        $newVariables = array();
        foreach ($data['variables'] as $key => $value) {
            array_push($newVariables, $value);
        }
        $this->variables = implode(';', $newVariables);
        $this->patternCode = SmsTypesMeliPayamak::toPatternCode($data['type']);
    }

    public function send()
    {
        $url = config('services.smsMeliPayamak.url');
        foreach ($this->mobiles as $mobile) {

            $data = [
                'username' => config('services.smsMeliPayamak.auth.uname'),
                'password' => config('services.smsMeliPayamak.auth.pass'),
                'text' => $this->variables,
                'to' => $mobile,
                'bodyId' => $this->patternCode,
            ];
            $response = $this->execute($url, $data);
            $this->addResponseToResult($response);
        }

        $this->SortResult();
        return $this->result;
    }

    protected function execute($url, $data = null)
    {

        $fields_string = "";

        if (!is_null($data)) {

            $fields_string = http_build_query($data);
        }

        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $url);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($handle, CURLOPT_POST, true);

        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

        $response = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        $curl_errno = curl_errno($handle);

        $curl_error = curl_error($handle);

        if ($curl_errno) {

            throw new \Exception($curl_error);
        }

        curl_close($handle);

        return $response;
    }

    private function addResponseToResult($response)
    {
        $response = json_decode($response);
        if ($response->StrRetStatus == "Ok") {
            $this->result[] = [
                'status' => SmsResult::SENT_SUCCESS,
                'code' => $response->Value,
                'message' => $response->StrRetStatus
            ];
        } else {
            $this->result[] = [
                'status' => SmsResult::SENT_Failed,
                'code' => $response->RetStatus,
                'message' => $response->StrRetStatus
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
