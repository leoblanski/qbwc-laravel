<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\ServiceType\Server;
use AaronGRTech\QbwcLaravel\ServiceType\Client;
use AaronGRTech\QbwcLaravel\ServiceType\Authenticate;
use AaronGRTech\QbwcLaravel\ServiceType\Send;
use AaronGRTech\QbwcLaravel\ServiceType\Receive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

class SoapController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = [
            AbstractSoapClientBase::WSDL_URL => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
            AbstractSoapClientBase::WSDL_CLASSMAP => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];
    }

    public function serverVersion(Request $request)
    {
        $server = new Server($this->options);
        $response = $server->serverVersion(new \AaronGRTech\QbwcLaravel\StructType\ServerVersion());
        return response()->json($response);
    }

    public function clientVersion(Request $request)
    {
        $client = new Client($this->options);
        $response = $client->clientVersion(new \AaronGRTech\QbwcLaravel\StructType\ClientVersion());
        return response()->json($response);
    }

    public function authenticate(Request $request)
    {
        $authenticate = new Authenticate($this->options);
        $response = $authenticate->authenticate(
            new \AaronGRTech\QbwcLaravel\StructType\Authenticate(
                config('qbwc.admin.user'),
                config('qbwc.admin.pass')
            )
        );
        return response()->json($response);
    }

    public function sendRequestXML(Request $request)
    {
        $send = new Send($this->options);
        $response = $send->sendRequestXML(new \AaronGRTech\QbwcLaravel\StructType\SendRequestXML());
        return response()->json($response);
    }

    public function receiveResponseXML(Request $request)
    {
        $receive = new Receive($this->options);
        $response = $receive->receiveResponseXML(new \AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXML());
        return response()->json($response);
    }
}
