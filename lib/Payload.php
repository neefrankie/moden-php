<?php

class Payload
{
    private $payload = [];
    private $signature = "";
    private $key;

    function __construct(string $key) {
        $this->key = $key;
    }

    public function add(string $key, string $value) {
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

        echo "Signature: $signature\n";

        $this->signature = $signature;

        return $this;
    }

    public function getSignature() {
        return $this->signature;
    }

    public function isSigned() {
        return $this->signature != "" && strlen($this->signature == 32);
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

        $xml .= "<sign><![CDATA[$this->signature]]></sign>";

        $xml .= "</xml>";
        return $xml;
    }

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

    public function setDeviceInfo(string $info) {
        $this->add('device_info', $info);
        return $this;
    }

    public function setNonce(string $nonce)
    {
        $this->add('nonce_str', $nonce);
        return $this;
    }

    public function setBody(string $body)
    {
        $this->add('body', $body);
        return $this;
    }

    public function setDetail(string $detail)
    {
        $this->add('detail', $detail);
        return $this;
    }

    public function setAttach(string $v) {
        $this->add('attach', $v);
        return $this;
    }

    public function setDealNo(string $no)
    {
        $this->add('out_trade_no', $no);
        return $this;
    }

    public function setCurrency(string $code = 'CNY') {
        $this->add('fee_type', $code);
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

    public function setStartTime(string $at) {
        $this->add('time_start', $at);
        return $this;
    }

    public function setExpireTime(string $at)
    {
        $this->add('time_expire', $at);
        return $this;
    }

    public function setGoodsTag(string $tag)
    {
        $this->add('goods_tag', $tag);
        return $this;
    }

    public function setNotifyUrl(string $url)
    {
        $this->add('notify_url', $url);
        return $this;
    }

    public function setDealType(string $type)
    {
        $this->add('trade_type', $type);
        return $this;
    }

    public function setPoductId(string $id)
    {
        $this->add('product_id', $id);
        return $this;
    }

    public function setOpendId(string $id)
    {
        $this->add('openid', $id);
        return $this;
    }
}