<?php
ini_set('date.timezone','Asia/Shanghai');

$dt = new DateTime();
var_dump((new DateTime())->format("YmdHis"));

$later = $dt->add(new DateInterval("PT5M"));
var_dump($later);

var_dump(time());
var_dump(time() + 600);