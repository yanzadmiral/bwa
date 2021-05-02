<?php
require './vendor/autoload.php';
// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-0H8ba4_NAIFOz2fY6mzkkVgi';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;
 
$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => 10000,
    ),
    'customer_details' => array(
        'first_name' => 'yayan',
        'last_name' => 'pratama',
        'email' => 'yayan.pra@example.com',
        'phone' => '08111222333',
    ),
);
 
$snapToken = \Midtrans\Snap::createTransaction($params)->redirect_url;
echo $snapToken;
?>