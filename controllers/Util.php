<?php

class Util
{
    public static function post(string $payload, string $endpoint, int $timeout = 30)
    {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $data = curl_exec($ch);
        return $data;
    }

    /**
     * Generate crypto strong random bytes the return its hexadecimal form.
     */
    public static function generateNonce(int $size=16)
    {
        $bytes = random_bytes($size);
        return bin2hex($bytes);
    }

    public static function parseXML(string $xml)
    {
        libxml_disable_entity_loader(true);

        $v = json_decode(
            json_encode(
                simplexml_load_string(
                    $xml, 
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            ),
            true
        );

        return $v;
    }
}