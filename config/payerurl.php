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

];
