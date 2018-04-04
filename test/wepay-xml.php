<?php

require dirname(__FILE__) .  './../WxpayAPI_php_v3.0.1/lib/WxPay.Data.php';

$order = new WxPayUnifiedOrder();
$order->SetAppid("abcdedfj");
$order->SetTotal_fee(100);
var_dump($order->ToXml());