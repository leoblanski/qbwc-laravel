<?php

namespace App\Http\Controllers\Qbwc;

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
    protected $server;
    protected $initialQueueSize;
    protected $ticket;

    public function __construct()
    {
        $options = [
            'uri' => config('qbwc.routes.prefix'),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];

        $this->server = new SoapServer(config('qbwc.soap.wsdl'), $options);
        $this->initialQueueSize = $this->queryQueue->queriesLeft();
    }

    public function handle()
    {
        $this->server->setObject($this);

        ob_start();
        $this->server->handle();
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

    public function sendRequestXML()
    {
        $query = null;

        if ($this->queryQueue->hasQueries()) {
            $query = $this->queryQueue->popQuery();
        }

        return new SendRequestXMLResponse($query->toQbxml());
    }

    public function receiveResponseXML($parameters)
    {
        $responseXML = $parameters->getResponse();
        // $hresult = $parameters->getHresult();
        // $message = $parameters->getMessage();

        $parsedData = $this->parseResponseXML($responseXML);
        $response = $parsedData->QBXMLMsgsRs;

        $callbackClass = $this->getCallbackClass($response);

        if ($callbackClass && class_exists($callbackClass)) {
            $callback = new $callbackClass();
            $callback->handleResponse($response);
        }

        $percentComplete = 100;

        if ($this->queryQueue->hasQueries()) {
            $percentComplete = 100 - (($this->queryQueue->queriesLeft() / $this->initialQueueSize) * 100);
        }

        return new ReceiveResponseXMLResponse($percentComplete);
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

    private function parseResponseXML($xml)
    {
        return simplexml_load_string($xml);
    }

    private function getCallbackClass($data)
    {
        if (isset($data->InvoiceQueryRs)) {
            return \App\Callbacks\InvoiceCallback::class;
        }

        // Add more conditions as needed for other types
        return null;
    }
}
