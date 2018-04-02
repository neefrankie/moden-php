<?php

$bytes = random_bytes(16);
$nonce = bin2hex($bytes);

$payload = [
    "appid" => "wxd930ea5d5a258f4f",
    "mch_id" => "10000100",
    "device_info" => "1000",
    "body" => "test",
    "nonce_str" => $nonce
];

$root = new SimpleXMLElement("<xml/>");

foreach ($payload as $k => $v) {
    $root->addChild($k, $v);
}

var_dump($root->asXML());