<?php

class Order
{
    private $payload = [];
    private $key;

    function __contruct(string $key)
    {
        $this->key = $key;
    }

    // Not exposed to external
    protected function add(string $key, string $value) {
        $this->payload[$key] = $value;
    }

    /**
     * Turn array to url query parameter string
     *
     * @return string
     */
    private function buildQuery()
    {
        $query = [];
        foreach ($this->payload as $k => $v) {
            if ($v == "" || is_array($v)) {
                continue;
            }

            // Ignore sign key if exists
            if ($k == "sign") {
                continue;
            }
            $query[] = "$k=$v";
        }

        return implode("&", $query);
    }

    private function generateSignature() {
        ksort($this->payload);

        $strToSign = $this->buildQuery() . "&key=$this->key";

        return strtoupper(md5($strToSign));
    }

    public function sign() {
        $signature = $this->generateSignature();

        $this->payload['sign'] = $signature;
        
        // sign_type could be omitted for MD5
        
        return $this;
    }

    public function getSignature() {
        return $this->payload['sign'];
    }

    public function isSigned() {
        return array_key_exists('sign', $this->payload);
    }

    public function toXML() {
        $this->sign();

        $xml = "<xml>";

        foreach($this->payload as $k => $v) {
            if (is_numeric($v)) {
                $xml .= "<$k>$v</$k>";
            } else {
                $xml .= "<$k><![CDATA[$v]]></$k>";
            }
        }

        $xml .= "</xml>";
        return $xml;
    }

    public function getPayload() {
        return $this->payload;
    }

    /**
     * Required fields for all types of order
     */
    public function setAppId(string $id)
    {
        $this->add('appid', $id);
        return $this;
    }

    public function setMchId(string $id)
    {
        $this->add('mch_id', $id);
        return $this;
    }

    public function setNonce(string $nonce)
    {
        $this->add('nonce_str', $nonce);
        return $this;
    }

    public function setNotifyUrl(string $url)
    {
        $this->add('notify_url', $url);
        return $this;
    }

    public function setOrderNo(string $no)
    {
        $this->add('out_trade_no', $no);
        return $this;
    }
    
    // The following are optional
    public function setCurrency(string $code = 'CNY') {
        $this->add('fee_type', $code);
        return $this;
    }

    public function setStartTime(string $at) {
        $this->add('time_start', $at);
        return $this;
    }

    public function setExpireTime(string $at)
    {
        $this->add('time_expire', $at);
        return $this;
    }
}
