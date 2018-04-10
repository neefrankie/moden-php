<?php
ini_set('date.timezone','Asia/Shanghai');

require dirname(__FILE__) . '../settings.php';
require dirname(__FILE__) . '/Order.php';
require dirname(__FILE__) . '/H5Order.php';
require dirname(__FILE__) . '/Payment.php';

$payment = new Payment($payConfig['appId'], $payConfig['mchId'], $payConfig['notifyUrl']);

$order = new H5Order($payConfig['key']);
$order->setBody('FTC Membership - FTChinese')
    ->setPrice(1)
    ->setUserIp($_SERVER['REMOTE_ADDR']);

$resp = $payment->unifiedOrder($order);

echo $resp->getResponse();