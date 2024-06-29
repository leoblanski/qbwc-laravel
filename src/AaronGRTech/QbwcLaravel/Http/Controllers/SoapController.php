<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString;
use AaronGRTech\QbwcLaravel\StructType\AuthenticateResponse;
use AaronGRTech\QbwcLaravel\StructType\ClientVersionResponse;
use AaronGRTech\QbwcLaravel\StructType\CloseConnectionResponse;
use AaronGRTech\QbwcLaravel\StructType\ConnectionErrorResponse;
use AaronGRTech\QbwcLaravel\StructType\GetLastErrorResponse;
use AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXMLResponse;
use AaronGRTech\QbwcLaravel\StructType\SendRequestXMLResponse;
use AaronGRTech\QbwcLaravel\StructType\ServerVersion;
use AaronGRTech\QbwcLaravel\StructType\ServerVersionResponse;
use App\Http\Controllers\Controller;
use SoapServer;

class SoapController extends Controller
{
    protected $options;
    protected $ticket;

    public function __construct()
    {
        $this->options = [
            'uri' => url(config('qbwc.routes.prefix')),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
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

    public function serverVersion()
    {
        $version = new ServerVersion(config('qbwc.soap.version'));
        return new ServerVersionResponse($version->getStrVersion());
    }

    public function clientVersion($parameters)
    {
        return new ClientVersionResponse('O:' . $parameters->getStrVersion());
    }

    public function authenticate($parameters)
    {
        $response = new ArrayOfString([
            '',
            'nvu'
        ]);

        if (
            $parameters->getStrUserName() == config('qbwc.user') ||
            $parameters->getStrPassword() == config('qbwc.password')
        ) {
            $this->generateTicket();

            $response = new ArrayOfString([
                $this->ticket,
                ''
            ]);
        }
        return new AuthenticateResponse($response);
    }

    public function sendRequestXML($parameters)
    {
        return new SendRequestXMLResponse();
    }

    public function receiveResponseXML($parameters)
    {
        return new ReceiveResponseXMLResponse();
    }

    public function connectionError($parameters)
    {
        $response = "Ticket: {$parameters->getTicket()} | ";
        $response .= "Hresult: {$parameters->getHresult()} | ";
        $response .= "Message: {$parameters->getMessage()}";

        return new ConnectionErrorResponse($response);
    }

    public function getLastError($parameters)
    {
        return new GetLastErrorResponse($parameters->getTicket());
    }

    public function closeConnection($parameters)
    {
        return new CloseConnectionResponse("Closing Connection | Ticket: {$parameters->getTicket()}");
    }

    private function generateTicket()
    {
        $this->ticket = uniqid(config('qbwc.soap.ticket_prefix'), true);
    }
}
