<?php

namespace FTC\WxPay;

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
        $root = new SimpleXMLElement("<xml/>");
        foreach($this->payload as $k => $v) {
            $root->addChild($k, $v);
        }
        $root->addChild('sign', $this->signature);
        return $root->asXML();
    }

    public function parseXML($xml) {

    }
}