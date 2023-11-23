<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'smsFaraz' => [
        'auth' => [
            'uname' => env('SMS_Faraz_uname'),
            'pass' => env('SMS_Faraz_pass'),
            'from' => "+100020400",
        ],
        'baseUri' => "https://ippanel.com/patterns/pattern?username=",
    ],

    'smsMeliPayamak' => [
        'auth' => [
            'uname' => env('SMS_MeliPayamak_uname'),
            'pass' => env('SMS_MeliPayamak_pass'),
        ],
        'url' => "https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber",
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_LINK'),
    ],

];
