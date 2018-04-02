<?php
$bytes = random_bytes(16);
$nonce = bin2hex($bytes);

$a = [];

$m = [
    "appid" => "wxd930ea5d5a258f4f",
    "mch_id" => "10000100",
    "device_info" => "1000",
    "body" => "test",
    "nonce_str" => $nonce
];

ksort($m);
var_dump($m);

foreach ($m as $k => $v) {
    $a[] = $k . "=" . $v;
}

$stringA = implode("&", $a);

echo "String to hash: $stringA\n";

$stringSignTemp = $stringA . "&key=192006250b4c09247ec02edce69f6a2d";

$sign = strtoupper(md5($stringSignTemp));

var_dump($sign);

