<?php

class OrderResponse {
    private $resp = [];

    function __construct(array $resp)
    {
        $this->resp = $resp;
    }

    public function isOrderSent()
    {
        return $this->resp['return_code'] == 'SUCCESS';
    }

    public function isOrderPlaced()
    {
        return array_key_exists('result_code', $this->resp) && $this->resp['result_code'] == 'SUCCESS';
    }

    public function getResponse()
    {
        return $this->resp;
    }
}