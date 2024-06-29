<?php
/**
 * This file aims to show you how to use this generated package.
 * In addition, the goal is to show which methods are available and the first needed parameter(s)
 * You have to use an associative array such as:
 * - the key must be a constant beginning with WSDL_ from AbstractSoapClientBase class (each generated ServiceType class extends this class)
 * - the value must be the corresponding key value (each option matches a {@link http://www.php.net/manual/en/soapclient.soapclient.php} option)
 * $options = [
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL => 'storage/app/wsdl/QBWebConnectorSvc.wsdl',
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_TRACE => true,
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_LOGIN => 'you_secret_login',
 * WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_PASSWORD => 'you_secret_password',
 * ];
 * etc...
 */
require_once __DIR__ . '/vendor/autoload.php';
/**
 * Minimal options
 */
$options = [
    WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL => 'storage/app/wsdl/QBWebConnectorSvc.wsdl',
    WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_CLASSMAP => \AaronGRTech\QbwcLaravel\ClassMap::get(),
];
/**
 * Samples for Server ServiceType
 */
$server = new \AaronGRTech\QbwcLaravel\ServiceType\Server($options);
/**
 * Sample call for serverVersion operation/method
 */
if ($server->serverVersion(new \AaronGRTech\QbwcLaravel\StructType\ServerVersion()) !== false) {
    print_r($server->getResult());
} else {
    print_r($server->getLastError());
}
/**
 * Samples for Client ServiceType
 */
$client = new \AaronGRTech\QbwcLaravel\ServiceType\Client($options);
/**
 * Sample call for clientVersion operation/method
 */
if ($client->clientVersion(new \AaronGRTech\QbwcLaravel\StructType\ClientVersion()) !== false) {
    print_r($client->getResult());
} else {
    print_r($client->getLastError());
}
/**
 * Samples for Authenticate ServiceType
 */
$authenticate = new \AaronGRTech\QbwcLaravel\ServiceType\Authenticate($options);
/**
 * Sample call for authenticate operation/method
 */
if ($authenticate->authenticate(new \AaronGRTech\QbwcLaravel\StructType\Authenticate()) !== false) {
    print_r($authenticate->getResult());
} else {
    print_r($authenticate->getLastError());
}
/**
 * Samples for Send ServiceType
 */
$send = new \AaronGRTech\QbwcLaravel\ServiceType\Send($options);
/**
 * Sample call for sendRequestXML operation/method
 */
if ($send->sendRequestXML(new \AaronGRTech\QbwcLaravel\StructType\SendRequestXML()) !== false) {
    print_r($send->getResult());
} else {
    print_r($send->getLastError());
}
/**
 * Samples for Receive ServiceType
 */
$receive = new \AaronGRTech\QbwcLaravel\ServiceType\Receive($options);
/**
 * Sample call for receiveResponseXML operation/method
 */
if ($receive->receiveResponseXML(new \AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXML()) !== false) {
    print_r($receive->getResult());
} else {
    print_r($receive->getLastError());
}
/**
 * Samples for Connection ServiceType
 */
$connection = new \AaronGRTech\QbwcLaravel\ServiceType\Connection($options);
/**
 * Sample call for connectionError operation/method
 */
if ($connection->connectionError(new \AaronGRTech\QbwcLaravel\StructType\ConnectionError()) !== false) {
    print_r($connection->getResult());
} else {
    print_r($connection->getLastError());
}
/**
 * Samples for Get ServiceType
 */
$get = new \AaronGRTech\QbwcLaravel\ServiceType\Get($options);
/**
 * Sample call for _getLastError operation/method
 */
if ($get->_getLastError(new \AaronGRTech\QbwcLaravel\StructType\GetLastError()) !== false) {
    print_r($get->getResult());
} else {
    print_r($get->getLastError());
}
/**
 * Samples for Close ServiceType
 */
$close = new \AaronGRTech\QbwcLaravel\ServiceType\Close($options);
/**
 * Sample call for closeConnection operation/method
 */
if ($close->closeConnection(new \AaronGRTech\QbwcLaravel\StructType\CloseConnection()) !== false) {
    print_r($close->getResult());
} else {
    print_r($close->getLastError());
}
