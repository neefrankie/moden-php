<?php

require dirname(__FILE__) . './../lib/Util.php';

$nonce = Util::generateNonce();

$payload = [
    "appid" => "wxd930ea5d5a258f4f",
    "mch_id" => "10000100",
    "device_info" => "1000",
    "body" => "test",
    "nonce_str" => $nonce
];

$root = new SimpleXMLElement("<xml/>", LIBXML_NOXMLDECL);

foreach ($payload as $k => $v) {
    $root->addChild($k, $v);
}

var_dump($root->asXML());

echo LIBXML_VERSION;
echo "\n";

// $string = <<<XML
// <document>
//  <title><![CDATA[Forty What?]]></title>
//  <from>Joe</from>
//  <to>Jane</to>
//  <body>I know that's the answer -- but what's the question?</body>
// </document>
// XML;

// $xml = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
// var_dump($xml);

// foreach($xml as $k => $v) {
//     echo "$k : $v\n";
// }
