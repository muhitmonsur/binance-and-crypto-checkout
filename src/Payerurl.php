<?php

namespace Payerurl;

class Payerurl
{
    public static function payment($invoiceId, $amount, $currency = 'usd', $data)
    {
        try {
            /**
             * Billing user info
             */
            $billing_fname = $data['first_name'] ?? 'First name';
            $billing_lname = $data['last_name'] ?? 'Last name';
            $billing_email = $data['email'] ??'test@email.com';

            /**
             * After successful payment customer will redirect to this url.
             */
            $redirect_to = $data['redirect_url']; //(order receive page)

            /**
             * THIS IS VERY IMPORTANT VARIABLE
             * Response URL/Callback URL our system will only send response to this url
             */

            #Note: after payment complete our system automatically sent payment detail on this notify_url in few seconds.
            $notify_url = $data['notify_url'];  //(system will send payment info in this page)


            /**
             * If you user cancel any payment, user will redirect to cancel url
             */
            $cancel_url = $data['cancel_url']; //(checkout page)

            /**
             * PayerUrl API credentials
             * Do not share the credentials
             * Get your API key : https://dash.payerurl.com/profile/get-api-credentials
             */

            $payerurl_public_key = config('payerurl.public_key');  // this credentials open for public
            $payerurl_secret_key = config('payerurl.secret_key'); // this credentials open for public

            /**
             * Order items
             */
            $items = [
                [
                    'name' => str_replace(' ', '_', 'Order item name'), // Replace spaces with '_' , no space allowed
                    'qty' => 'Order item quantity',
                    'price' => '123',
                ]
            ];

            /**
             * API params
             */
            $args = [
                'order_id'      => $invoiceId,  // must be unique
                'amount'        => $amount, //integer value
                'items'         => $items,
                'currency'      => $currency,  // currency in small letter
                'billing_fname' => $billing_fname,
                'billing_lname' => $billing_lname,
                'billing_email' => $billing_email,
                'redirect_to'   => $redirect_to,  //After successful payment customer will redirect to this url.(order receive page)
                'notify_url'    => $notify_url,  //After payment complete our system automatically sent payment detail on this notify_url in few seconds.(system will sent payment info in this page)
                'cancel_url'    => $cancel_url,  //If you user cancel any payment, user will redirect to cancel url.(checkout page)
                'type'          => 'lrb',
            ];

            /**
             * Generate signature
             */
            ksort($args);
            $args = http_build_query($args);
            $signature = hash_hmac('sha256', $args, $payerurl_secret_key);
            $authStr = base64_encode(sprintf('%s:%s', $payerurl_public_key, $signature));

            /**
             * Send API response
             */
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, config('payerurl.api_url'));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type:application/x-www-form-urlencoded;charset=UTF-8',
                'Authorization:' . sprintf('Bearer %s', $authStr),
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $response = json_decode($response);

            /**
             * Redirect user to payerurl payment page
             */
            if ($httpCode === 200 && isset($response->redirectTO) && !empty($response->redirectTO)) {
                return [
                    'status' => true,
                    'redirectUrl' => $response->redirectTO,
                ];

            } else {
                return [
                    'status' => false,
                    'message' => "Something went wrong",
                ];
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
