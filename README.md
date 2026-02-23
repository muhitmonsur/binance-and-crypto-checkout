# Binance & Crypto Checkout for Laravel

[![Latest Stable Version](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/v/stable)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![Total Downloads](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/downloads)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)
[![License](https://poser.pugx.org/payerurl/binance-and-crypto-checkout/license)](https://packagist.org/packages/payerurl/binance-and-crypto-checkout)

![Banner](https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/banner-772x250.png)

---

## 🚀 Introduction

**Binance & Crypto Checkout for Laravel** is a secure cryptocurrency payment gateway powered by **Payerurl**.

It enables merchants to accept crypto payments directly into their wallets without intermediaries.

Customers never leave your Laravel checkout page.

---

## 💳 Supported Payment Methods

- Binance QR Code
- Binance Pay
- USDT (TRC20 / ERC20)
- USDC (ERC20)
- Bitcoin (BTC)
- Ethereum (ETH ERC20)

---

## 🌍 Key Features

- ✅ 169+ Fiat Currency Support (USD, EUR, GBP, CAD, BDT, etc.)
- ✅ Real-Time Exchange Rate Conversion
- ✅ Direct Wallet Settlement
- ✅ No KYC Required (Basic Accounts)
- ✅ Secure API Verification
- ✅ Instant Order Status Update
- ✅ 100% Free & Open Source
- ✅ Laravel 8, 9, 10, 11 Compatible
- ✅ 24/7 Telegram Support

---

## 🔗 Live Demo

👉 https://payerurl.com/

---

## 📦 Installation

```bash
composer require payerurl/binance-and-crypto-checkout
```
## ⚙️Publish Configuration
```bash
php artisan vendor:publish --provider="Payerurl\Providers\AppServiceProvider" --tag=config
```

## 🔑 Environment Configuration
Add your API credentials to .env:
```
PAYERURL_PUBLIC_KEY="your_public_key"
PAYERURL_SECRET_KEY="your_secret_key"
```
Get your API keys from: https://dash.payerurl.com/profile/get-api-credentials

## 💳 Payment Integration
#### 📌 Function Signature
```php
payment($invoiceId, $amount, $currency = 'usd', $data)
```
## ✅ Required Parameters
| Parameter  | Type   | Required | Description                           |
| ---------- | ------ | -------- | ------------------------------------- |
| $invoiceId | string | Yes      | Unique Order ID                       |
| $amount    | int    | Yes      | Amount in smallest unit (e.g., cents) |
| $currency  | string | No       | Default: usd                          |
| $data      | array  | Yes      | Customer & URL information            |

## 📦 $data Array Structure
```php
$data = [
    'first_name'   => 'John',
    'last_name'    => 'Doe',
    'email'        => 'john@example.com',
    'redirect_url' => 'https://yourdomain.com/payment-success',
    'notify_url'   => 'https://yourdomain.com/api/payment-notify',
    'cancel_url'   => 'https://yourdomain.com/checkout'
];
```
## 🧪 Example Controller Integration
```php
use Payerurl\Payerurl;

public function pay()
{
    $invoiceId = 'INV-1001';
    $amount = 1000; // $10.00
    $currency = 'usd';

    $data = [
        'first_name' => 'Alice',
        'last_name' => 'Smith',
        'email' => 'alice@example.com',
        'redirect_url' => route('payment.success'),
        'notify_url' => route('payment.notify'),
        'cancel_url' => route('cart')
    ];

    $response = Payerurl::payment($invoiceId, $amount, $currency, $data);

    if ($response['status']) {
        return redirect($response['redirectUrl']);
    }

    return back()->with('error', $response['message']);
}
```

## 🔔 Webhook (Payment Notify) Example
Add route:

```php
Route::post('/payment-notify', [PaymentController::class, 'notify'])->name('payment.notify');
```
## 🔄 API Response
#### ✅ Success
```php
[
    'status' => true,
    'redirectUrl' => "https://dash.payerurl.com/payment/WP112XXXXX"
]
```
#### ❌ Error
```php
[
    'status' => false,
    'message' => "Something went wrong. Please try again."
]
```

## 🔐 Security

- ✅ Secure server-to-server API communication
- ✅ Callback verification
- ✅ API key authentication
- ✅ No sensitive customer data stored

## 🖼 Screenshots
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-1.png">
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-2.png">
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-4.png">
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-6.png">
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-7.png">
<img src="https://raw.githubusercontent.com/muhitmonsur/assets/refs/heads/main/screenshot-8.png">



## 🧾 License
This package is open-sourced software licensed under the MIT License.

## 📞 Support
#### 🌐 Website: https://payerurl.com
#### 📞 Telegram: https://t.me/Payerurl
#### 📧 Email: support@payerurl.com
