<?php

class H5Order extends Order
{
    function __contruct(string $key)
    {
        parent::__contruct($key);
        $this->add('trade_type', 'MWEB');
    }

    // H5 specific fields
    public function setBody(string $body)
    {
        $this->add('body', $body);
        return $this;
    }

    public function setPrice(int $amount)
    {
        $this->add('total_fee', $amount);
        return $this;
    }

    public function setUserIp(string $ip)
    {
        $this->add('spbill_create_ip', $ip);
        return $this;
    }
}