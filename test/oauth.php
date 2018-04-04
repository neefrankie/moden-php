<?php
require dirname(__FILE__) . "./../WxpayAPI_php_v3.0.1/example/WxPay.JsApiPay.php";

$tools = new JsApiPay();
$openId = $tools->GetOpenid();