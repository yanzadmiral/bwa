<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\PaymentLog;

class WebHookController extends Controller
{
    public function midtransHandler(Request $request)
    {
        $data = $request->all();

        $signaturKey = $data['signature_key'];

        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];
        $serverkey  = env('MIDTRANS_SERVER_KEY');

        $mySignaturKey = hash('sha512',$orderId.$statusCode.$grossAmount.$serverkey);

        $transactionStatus = $data['transaction_status'];
        $type = $data['payment_type'];
        $fraudStatus = $data['fraud_status'];

        if ($signaturKey !== $mySignaturKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'invalid signature'
            ], 400);
        }

        $realorderId = explode('-',$orderId);
        $order = Order::find($realorderId[0]);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'order id not found'
            ], 400);
        }

        if ($order->status === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => 'operation not permited'
            ], 405);
        }

        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'challenge'){
                $order->status = 'challenge';
            } else if ($fraudStatus == 'accept'){
                $order->status = 'success';
            }
        } else if ($transactionStatus == 'settlement'){
            $order->status = 'success';
        } else if ($transactionStatus == 'cancel' ||
          $transactionStatus == 'deny' ||
          $transactionStatus == 'expire'){
            $order->status = 'failure';
        } else if ($transactionStatus == 'pending'){
            $order->status = 'pending';
        }

        PaymentLog::create([
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'order_id' => $realorderId[0],
            'payment_type' => $type
        ]);
        $order->save();

        if ($order->status === 'success') {
            
        }

        return response()->json('ok');

    }
}
