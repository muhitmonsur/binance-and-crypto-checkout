<?php
return [
    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    |
    */

    'api_url' => "https://api-v2.payerurl.com/api/payment",


    /*
    |--------------------------------------------------------------------------
    | PayerUrl API credentials
    |--------------------------------------------------------------------------
    |
    | PayerUrl API credentials
    | Do not share the credentials
    | Get your API key : https://dash.payerurl.com/profile/get-api-credentials
    |
    |
    */

    'public_key' => env('PAYERURL_PUBLIC_KEY'),
    'secret_key' => env('PAYERURL_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Notify / Webhook Route
    |--------------------------------------------------------------------------
    |
    | Payerurl sends a POST request to this URL after payment.
    | Default: POST /payerurl/notify (route name: payerurl.notify)
    |
    */

    'route' => [
        'enabled' => true,
        'prefix' => 'payerurl',
        'middleware' => [],
    ],

    'log_notifications' => env('PAYERURL_LOG_NOTIFICATIONS', false),

];
