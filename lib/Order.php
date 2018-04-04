<?php

class Order
{
    private $payload;

    function __contruct(Payload $payload){
        $this->payload = $payload;
    }

    public function place() {
        $endpoint = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    }
}
