<?php
ini_set('date.timezone','Asia/Shanghai');

require dirname(__FILE__) . './../settings.php';
require dirname(__FILE__) . './../lib/Payload.php';
require dirname(__FILE__) . './../lib/Order.php';
require dirname(__FILE__) . './../lib/Util.php';

$payload = new Payload($payConfig["apiKey"]);

$now = new DateTime();
const TIME_LAYOUT = "YmdHis";

$payload->setAppId($payConfig["appId"])
    ->setMchID($payConfig["mchId"])
    ->setNonce(Util::generateNonce())
    ->setBody("test")
    ->setAttach("test")
    ->setDealNo($now->format(TIME_LAYOUT) . Util::generateNonce(9))
    ->setPrice(1)
    ->setStartTime($now->format(TIME_LAYOUT))
    ->setExpireTime($now->add(new DateInterval("PT5M"))->format(TIME_LAYOUT))
    ->setGoodsTag("test")
    ->setNotifyUrl("http://paysdk.weixin.qq.com/example/notify.php")
    ->setDealType("MWEB");

var_dump($payload->toXML());