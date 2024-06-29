<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\Services\SoapService;
use AaronGRTech\QbwcLaravel\StructType\ServerVersion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapServer;

class SoapDispatcherController extends Controller
{
    protected $options;
    protected $soapService;

    public function __construct(SoapService $soapService)
    {
        $this->options = [
            'uri' => url(config('qbwc.routes.prefix')),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];
        $this->soapService = $soapService;
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
        return $this->soapService->serverVersion($version);
    }
}
