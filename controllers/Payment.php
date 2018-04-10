<?php
ini_set('date.timezone','Asia/Shanghai');

require dirname(__FILE__) . '/Util.php';
require dirname(__FILE__) . '/OrderResponse.php';

class Payment
{
    const TIME_LAYOUT = "YmdHis";
    private $appId;
    private $mchId;
    private $notifyUrl;
    const BASE_URL = 'https://api.mch.weixin.qq.com';

    function __construct($appId, $mchId, $notifyUrl)
    {
        $this->appId = $appId;
        $this->mchId = $mchId;
        $this->notifyUrl = $notifyUrl;
    }

    function unifiedOrder(Order $order)
    {
        $endpoint = self::BASE_URL . '/pay/unifiedorder';

        $now = new DateTime();

        $order.setAppId($this->appId);
        $order.setMchId($this->mchId);
        $order.setNonce(Util::generateNonce());
        $order.setNotifyUrl($this->notifyUrl);
        $order.setOrderNo($now->format(TIME_LAYOUT) . Util::generateNonce(9));
        $order.setStartTime($now->format(self::TIME_LAYOUT));
        $order.setExpireTime($now->add(new DateInterval("PT5M"))->format(self::TIME_LAYOUT));

        $order->sign();

        $payload = $order->toXML();

        $resp = Util::post($payload, $endpoint);

        $response = new OrderResponse($resp);
        
        return $response;
    }
}