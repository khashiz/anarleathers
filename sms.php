<?php
ini_set("soap.wsdl_cache_enabled", "0");
$sms_client = new SoapClient('http://api.payamak-panel.com/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));

$parameters['username'] = "09124131910";
$parameters['password'] = "ENGSC";
$parameters['text'] = "1234";
$parameters['to'] = "09124131910";
$parameters['bodyId'] = 91262;
echo $sms_client->SendByBaseNumber2($parameters)->SendSimpleSMS2Result;