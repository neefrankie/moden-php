<?php

require dirname(__FILE__) . './../lib/Payload.php';
require dirname(__FILE__) . './../lib/Util.php';

$nonce = Util::generateNonce();

$payload = new Payload("abcdadfljaleoad09");

$payload->setAppId("wxd930ea5d5a258f4f")
    -> setMchId("10000100")
    -> setDeviceInfo("1000")
    -> setBody("test")
    -> setNonce($nonce);

var_dump($payload->toXML());