<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\Services\SoapService;
use AaronGRTech\QbwcLaravel\ServiceType\Authenticate;
use AaronGRTech\QbwcLaravel\ServiceType\Client;
use AaronGRTech\QbwcLaravel\ServiceType\Receive;
use AaronGRTech\QbwcLaravel\ServiceType\Send;
use AaronGRTech\QbwcLaravel\ServiceType\Server;
use AaronGRTech\QbwcLaravel\StructType\ServerVersion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapServer;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

class SoapDispatcherController extends Controller
{
    protected $options;
    protected $clientOptions;

    public function __construct()
    {
        $this->options = [
            'uri' => url(config('qbwc.routes.prefix')),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];

        $this->clientOptions = [
            AbstractSoapClientBase::WSDL_URL => config('qbwc.soap.wsdl'),
            AbstractSoapClientBase::WSDL_CLASSMAP => \AaronGRTech\QbwcLaravel\ClassMap::get(),
            AbstractSoapClientBase::WSDL_URI => config('qbwc.routes.prefix'),
        ];
    }


    public function handle()
    {
        $server = app()->make(SoapServer::class);
        $server->setObject($this);

        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response, 200)->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function serverVersion($parameters)
    {
        $version = new ServerVersion();
        $server = new Server($this->clientOptions);
        return $server->serverVersion($version);
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
