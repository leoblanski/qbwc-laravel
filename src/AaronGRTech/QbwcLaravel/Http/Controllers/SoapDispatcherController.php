<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\Services\SoapService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapServer;

class SoapDispatcherController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = [
            'uri' => url(config('qbwc.routes.prefix')),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];
    }

    public function handle(Request $request)
    {
        $server = new SoapServer(config('qbwc.soap.wsdl'), $this->options);
        $server->setObject(new SoapService());

        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response, 200)->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}
