<?php

namespace AaronGRTech\QbwcLaravel\Services;

use AaronGRTech\QbwcLaravel\ServiceType\Server;
use AaronGRTech\QbwcLaravel\ServiceType\Client;
use AaronGRTech\QbwcLaravel\ServiceType\Authenticate;
use AaronGRTech\QbwcLaravel\ServiceType\Send;
use AaronGRTech\QbwcLaravel\ServiceType\Receive;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

class SoapService
{
    protected $options;

    public function __construct()
    {
        $this->options = [
            AbstractSoapClientBase::WSDL_URL => config('qbwc.soap.wsdl'),
            AbstractSoapClientBase::WSDL_CLASSMAP => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];
    }

    public function serverVersion($parameters)
    {
        $server = new Server($this->options);
        return $server->serverVersion($parameters);
    }

    public function clientVersion($parameters)
    {
        $client = new Client($this->options);
        return $client->clientVersion($parameters);
    }

    public function authenticate($parameters)
    {
        $authenticate = new Authenticate($this->options);
        return $authenticate->authenticate($parameters);
    }

    public function sendRequestXML($parameters)
    {
        $send = new Send($this->options);
        return $send->sendRequestXML($parameters);
    }

    public function receiveResponseXML($parameters)
    {
        $receive = new Receive($this->options);
        return $receive->receiveResponseXML($parameters);
    }
}
