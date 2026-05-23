<?php

namespace Payerurl\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifyController extends Controller
{
    public function payerurlCallback(Request $request)
    {
        /**
         * Payerurl API credentials
         */
        $payerurl_public_key = config('payerurl.public_key');
        $payerurl_secret_key = config('payerurl.secret_key');

        $headers = $request->headers->all();
        $auth = [];

        // Get Authorization Header
        if (!$request->header('Authorization')) {

            if (!$request->has('authStr')) {
                return response()->json([
                    'status' => 2030,
                    'message' => 'Authorization not found'
                ]);
            }

            $authStr_post = base64_decode($request->authStr);
            $auth = explode(':', $authStr_post);

        } else {

            $authStr = str_replace('Bearer ', '', $request->header('Authorization'));
            $authStr = base64_decode($authStr);
            $auth = explode(':', $authStr);
        }

        /**
         * Check Public Key
         */
        if (!isset($auth[0]) || $payerurl_public_key != $auth[0]) {

            return response()->json([
                'status' => 2030,
                'message' => "Public key doesn't match"
            ]);
        }

        /**
         * Get Data
         */
        $GETDATA = [
            'order_id'             => $request->order_id,
            'ext_transaction_id'   => $request->ext_transaction_id,
            'transaction_id'       => $request->transaction_id,
            'status_code'          => $request->status_code,
            'note'                 => $request->note,
            'confirm_rcv_amnt'     => $request->confirm_rcv_amnt,
            'confirm_rcv_amnt_curr'=> $request->confirm_rcv_amnt_curr,
            'coin_rcv_amnt'        => $request->coin_rcv_amnt,
            'coin_rcv_amnt_curr'   => $request->coin_rcv_amnt_curr,
            'txn_time'             => $request->txn_time,
        ];

        /**
         * Validation
         */
        if (empty($GETDATA['transaction_id'])) {

            return response()->json([
                'status' => 2050,
                'message' => 'Transaction ID not found'
            ]);
        }

        if (empty($GETDATA['order_id'])) {

            return response()->json([
                'status' => 2050,
                'message' => 'Order ID not found'
            ]);
        }

        /**
         * Order Cancelled
         */
        if ($GETDATA['status_code'] == 20000) {

            return response()->json([
                'status' => 20000,
                'message' => 'Order Cancelled'
            ]);
        }

        /**
         * Order Not Complete
         */
        if ($GETDATA['status_code'] != 200) {

            return response()->json([
                'status' => 2050,
                'message' => 'Order not complete'
            ]);
        }

        /**
         * ADVANCE SECURITY CHECK
         */
        ksort($GETDATA);

        $args = http_build_query($GETDATA);

        // Correct Signature Generate
        $signature = hash_hmac('sha256', $args, $payerurl_secret_key);

        if (!isset($auth[1]) || !hash_equals($signature, $auth[1])) {

            return response()->json([
                'status' => 2030,
                'message' => 'Signature not matched'
            ]);
        }

        /**
         * Log Data
         */
        Log::channel('single')->info('Payerurl Callback', $GETDATA);

        return response()->json([
            'status' => 2040,
            'message' => $GETDATA
        ]);

    }
}
