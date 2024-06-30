<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString;
use AaronGRTech\QbwcLaravel\Queue\QbQueryQueue;
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
    protected $queryQueue;
    protected $initialQueueSize;
    protected $options;
    protected $ticket;

    public function __construct(QbQueryQueue $queryQueue)
    {
        $this->queryQueue = $queryQueue;
        $this->initialQueueSize = $this->queryQueue->queriesLeft();
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

        $callbackClass = $this->getCallbackClass($parsedData);

        if ($callbackClass && class_exists($callbackClass)) {
            $callback = new $callbackClass();
            $callback->handleResponse($parsedData);
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
        if (isset($data->Invoice)) {
            return \App\Callbacks\InvoiceCallback::class;
        }

        // Add more conditions as needed for other types
        return null;
    }
}
