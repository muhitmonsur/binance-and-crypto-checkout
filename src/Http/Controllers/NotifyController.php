<?php

namespace Payerurl\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Payerurl\Events\PaymentNotifySuccess;

class NotifyController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payerurlPublicKey = config('payerurl.public_key');
        $payerurlSecretKey = config('payerurl.secret_key');

        $auth = $this->resolveAuth($request);

        if ($payerurlPublicKey !== ($auth[0] ?? null)) {
            return $this->jsonResponse(2030, 'Public key doesn\'t match');
        }

        $getData = [
            'order_id' => $request->input('order_id'),
            'ext_transaction_id' => $request->input('ext_transaction_id'),
            'transaction_id' => $request->input('transaction_id'),
            'status_code' => $request->input('status_code'),
            'note' => $request->input('note'),
            'confirm_rcv_amnt' => $request->input('confirm_rcv_amnt'),
            'confirm_rcv_amnt_curr' => $request->input('confirm_rcv_amnt_curr'),
            'coin_rcv_amnt' => $request->input('coin_rcv_amnt'),
            'coin_rcv_amnt_curr' => $request->input('coin_rcv_amnt_curr'),
            'txn_time' => $request->input('txn_time'),
        ];

        if (empty($getData['transaction_id'])) {
            return $this->jsonResponse(2050, 'Transaction ID not found');
        }

        if (empty($getData['order_id'])) {
            return $this->jsonResponse(2050, 'Order ID not found');
        }

        if ((int) $getData['status_code'] === 20000) {
            return $this->jsonResponse(20000, 'Order Cancelled');
        }

        if ((int) $getData['status_code'] !== 200) {
            return $this->jsonResponse(2050, 'Order not complete');
        }

        ksort($getData);
        $queryString = http_build_query($getData);
        $signature = hash_hmac('sha256', $queryString, $payerurlSecretKey);

        if (!hash_equals($signature, $auth[1] ?? '')) {
            return $this->jsonResponse(2030, 'Signature not matched');
        }

        event(new PaymentNotifySuccess($getData));

        $data = ['status' => 2040, 'message' => $getData];

        if (config('payerurl.log_notifications', false)) {
            Log::info('Payerurl notify', $data);
        }

        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array{0: string|null, 1: string|null}
     */
    protected function resolveAuth(Request $request): array
    {
        $authorization = $request->header('Authorization');

        if ($authorization) {
            $authStr = str_replace('Bearer ', '', $authorization);
            $authStr = base64_decode($authStr, true);
        } else {
            $authStrPost = $request->input('authStr');
            $authStr = $authStrPost ? base64_decode($authStrPost, true) : false;
        }

        if ($authStr === false) {
            return [null, null];
        }

        $auth = explode(':', $authStr, 2);

        return [
            $auth[0] ?? null,
            $auth[1] ?? null,
        ];
    }

    protected function jsonResponse(int $status, string $message): JsonResponse
    {
        return response()->json(
            ['status' => $status, 'message' => $message],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
