# PayerURL Laravel Package

[![Latest Stable Version](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/v/stable)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![Total Downloads](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/downloads)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![License](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/license)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)

A simple Laravel package for [brief package description here].

## Installation

```bash
composer require payerurl/binance-and-crypto-checkout
```

#### Publish config file

You should publish the config file with:

```
php artisan vendor:publish --provider="Payerurl\Providers\AppServiceProvider" --tag=config
```

In `config/payerurl.php` config file you should set `payerurl` global path.

```php
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
```



## 💳 PayerURL Payment Integration – Laravel
###### This method allows you to integrate with the PayerURL Payment Gateway using a simple PHP function. It's designed for systems where server-to-server communication is preferred over frontend SDKs.

## 📌 Function: payment($invoiceId, $amount, $currency = 'usd', $data)
###### Handles the payment process with PayerURL API and redirects the customer to the payment page.

## 🔑 GET API KEY
Get your API key : https://dash.payerurl.com/profile/get-api-credentials
<img src="https://raw.githubusercontent.com/RashiqulRony/rony.mmj/refs/heads/master/payerurl.png">

### Using .env

```
PAYERURL_PUBLIC_KEY="Your_public_key"
PAYERURL_SECRET_KEY="Your_secret_key"
```


## ✅ Required Parameters
| Name | Type | Required | Description |
| --- | --- | --- | --- |
| $invoiceId | string | ✅ | Unique invoice or order ID. |
| $amount | int | ✅ | Payment amount (in smallest currency unit, e.g., cents). |
| $currency | string | ❌ | Currency code (e.g., usd, bdt). Default: usd. |
| $data | array | ✅ | Contains customer info, redirect URLs, and API credentials. |


## 🔑 $data Array Structure

~~~php
$data = [
    'first_name'   => 'John',             // Optional
    'last_name'    => 'Doe',              // Optional
    'email'        => 'john@example.com', // Optional
    'redirect_url' => 'https://yourdomain.com/payment-success',
    'notify_url'   => 'https://yourdomain.com/api/payment-notify',
    'cancel_url'   => 'https://yourdomain.com/checkout'
];
~~~

## 🚀 How It Works
1. Collect user and order info on your platform.
2. Call the payment() function with required details.
3. User is redirected to PayerURL payment page.
4. After payment:
    * User is redirected to redirect_url.
    * Your backend receives a callback at notify_url with transaction details.
    * On cancellation, user is returned to cancel_url.

   

## 🧪 Sample Usage
~~~php
use Payerurl\Payerurl;

$invoiceId = 'INV-1001';
$amount = 1000; // $10.00
$currency = 'usd';

$data = [
    'first_name' => 'Alice',
    'last_name' => 'Smith',
    'email' => 'alice@example.com',
    'redirect_url' => 'https://yoursite.com/payment-success',
    'notify_url' => 'https://yoursite.com/api/payment-notify',
    'cancel_url' => 'https://yoursite.com/cart'
];

$response = Payerurl::payment($invoiceId, $amount, $currency, $data);
~~~

## 🧪 Response
###### Payment success 
~~~
'status' => true,
'redirectUrl' => "https://dash.payerurl.com/payment/WP112*****", // Payment page URL
~~~

###### Payment Error
~~~
'status' => false,
'message' => "Something went wrong. Please try again.",
~~~


---

✅ **Done!**  
When you push this `README.md` to your GitHub repository, it will show badges immediately!  
**No manual update needed** — Packagist will auto-refresh version/downloads after you push tags/releases.

---

Would you also like me to show you **how to make automatic GitHub Actions to update your Packagist on every push** (extra pro setup)? 🚀  
👉 (it’s very easy and professional) — just tell me!











