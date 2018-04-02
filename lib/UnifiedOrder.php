<?php
/**
 * @package FTC\WxPay
 * @author Ni Weiguo <neefrankie@gmail.com>
 * @license http://www.spdx.org/licenses/MIT MIT License
 */
namespace FTC\WxPay;

class Order extends Payload
{
    function __contruct(string $key){
        parent::__contruct($key);
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
        $this->add('opendi', $id);
        return $this;
    }
}
