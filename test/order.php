<?php

require 'settings.php';
require 'lib/Payload.php';
require 'lib/UnifiedOrder.php';

$bytes = random_bytes(16);
$nonce = bin2hex($bytes);

$order = new \FTC\WxPay\Order('192006250b4c09247ec02edce69f6a2d');

$order->setAppId($payConfig['appId'])
    ->setMchId($payConfig['mchId'])
    ->setDeviceInfo('WEB')
    ->setNonce($nonce);

$order->sign();

var_dump($order);

// echo "Signature: $order->getSignature()";

// echo "XML: $order->toXML()";