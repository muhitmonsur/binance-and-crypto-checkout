# Binance & Crypto Checkout for Laravel

[![Latest Stable Version](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/v/stable)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![Total Downloads](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/downloads)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![License](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/license)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)

## Introduction

The Binance and Crypto Payment Gateway Laravel package is powered by Payerurl. This package acts as a robust cryptocurrency payment processor, allowing merchants and developers to receive customer payments directly into their crypto wallets without the need for a middleman or intermediary account. We specialize in Binance QR code payments, providing a smooth, integrated experience where users never have to leave your Laravel application to complete a transaction.

### Binance QR Code Payment

This package is the ideal solution for developers seeking a secure Binance payment integration for Laravel. Binance Pay is a contactless, borderless, and highly secure payment method. By using this package, you can accept payments via Binance QR codes and process transactions through the Binance personal account API.

The package serves as a seamless bridge between Binance and your Laravel application. Customers simply scan the generated QR code on your checkout page to finish the transaction. This process is:

* **Fast and Simple**: No complex redirects or external logins for the user.
* **Cost-Effective**: Incurs no network fees or additional hidden costs.
* **Secure**: Enhanced security protocols help avoid scams and ensure transaction safety.

### [LIVE DEMO](https://payerurl.com/)

### How This Package Works

The Binance and Crypto Payment Gateway automatically converts any fiat currency to the selected cryptocurrency using live exchange rates. Once the payment is verified, funds are credited instantly to the merchant's wallet. The package then utilizes a secure API response to update your application's order status (e.g., from "Pending" to "Processing") in real-time.

### Key Features

* **Extensive Network Support**: Supports Binance QR payment, Binance Pay, USDT (TRC20/ERC20), USDC (ERC20), Bitcoin (BTC), and Ethereum (ETH ERC20).
* **Fiat Compatibility**: Supports over 169+ fiat currencies (USD, CAD, GBP, EUR, etc.) with real-time exchange rates powered by payerurl.com.
* **Developer Friendly**: 100% Free Open Source package designed specifically for the Laravel ecosystem.
* **Privacy Focused**: No bank account or mandatory personal identity verification required.
* **Simple Integration**: Streamlined signup process with easy API key integration.
* **Accessibility**: No KYC required for withdrawals on Basic accounts.
* **Dedicated Support**: 24/7 technical assistance for integration via Telegram: https://t.me/Payerurl.
* **Compatibility**: Optimized for Laravel 8.x, 9.x, 10.x, and 11.x.

### About Payerurl

Payerurl is a premier payment processor enabling direct cryptocurrency transfers from customers to merchant wallets. Merchants can integrate Binance personal/merchant APIs alongside various receiving wallets including USDT, BTC, ETH, and USDC. We utilize live market rates to ensure accurate conversion from local fiat currencies to the corresponding cryptocurrency amount.

## Installation

```bash
composer require payerurl/binance-and-crypto-checkout
```

#### Publish config file

You should publish the config file with:

```bash
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

This method allows you to integrate with the PayerURL Payment Gateway using a simple PHP function. It's designed for systems where server-to-server communication is preferred over frontend SDKs.

## 📌 Function: payment($invoiceId, $amount, $currency = 'usd', $data)

Handles the payment process with PayerURL API and redirects the customer to the payment page.

## 🔑 GET API KEY

Get your API key: https://dash.payerurl.com/profile/get-api-credentials

<img src="https://raw.githubusercontent.com/RashiqulRony/rony.mmj/refs/heads/master/payerurl.png">

### Using .env

```env
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

```php
$data = [
    'first_name'   => 'John',             // Optional
    'last_name'    => 'Doe',              // Optional
    'email'        => 'john@example.com', // Optional
    'redirect_url' => 'https://yourdomain.com/payment-success',
    'notify_url'   => 'https://yourdomain.com/api/payment-notify',
    'cancel_url'   => 'https://yourdomain.com/checkout'
];
```

## 🚀 How It Works

1. Collect user and order info on your platform.
2. Call the payment() function with required details.
3. User is redirected to PayerURL payment page.
4. After payment:
   * User is redirected to redirect_url.
   * Your backend receives a callback at notify_url with transaction details.
   * On cancellation, user is returned to cancel_url.

## 🧪 Sample Usage

```php
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
```

## 🧪 Response

#### Payment success

```php
'status' => true,
'redirectUrl' => "https://dash.payerurl.com/payment/WP112*****", // Payment page URL
```

#### Payment Error

```php
'status' => false,
'message' => "Something went wrong. Please try again.",
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support and questions, please contact us via:
- Telegram: https://t.me/Payerurl
- Website: https://payerurl.com

---
