<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Order;
class OrderController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $order = Order::query();

        $order->when($userId,function($query) use ($userId)
        {
            return $query->where('user_id','=',$userId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $order->get()
        ], 200);
    }

    public function create(Request $request)
    {
        $user = $request->input('user');
        $course = $request->input('course');
        
        $order = Order::create([
            'user_id' => $user['id'],
            'course_id' => $course['id']
        ]);

        $transactionDetails = [
            'order_id' => Str::random(5),
            'gross_amount' => $course['price']
        ];
        
        $itemDetails = [
            [
                'id' => $course['id'],
                'price' => $course['price'],
                'quantity' => 1,
                'name' => $course['name'],
                'brand' => 'Yayan Shop',
                'category' => 'Online Course',
            ]
        ];

        $customerDetails = [
            'first_name' => $user['name'],
            'email' => $user['email'],
        ];

        $midtransparams = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        $midtransSnapUrl = $this->getMidtransSnapUrl($midtransparams);
        $order->snap_url = $midtransSnapUrl;

        $order->metadata = [
            'course_id' => $course['id'],
            'course_name' => $course['name'],
            'course_thumbnail' => $course['thumbnail'],
            'course_price' => $course['price'],
            'course_level' => $course['level'],
        ];

        $order->save();
        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }

    public function getMidtransSnapUrl($params)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_PRODUCTION');
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_3DS');

        $snapUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

        return $snapUrl;
    }
}
