<?php

namespace AaronGRTech\QbwcLaravel\Http\Controllers;

use AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString;
use AaronGRTech\QbwcLaravel\StructType\Queries\QbxmlQuery;
use AaronGRTech\QbwcLaravel\Services\QueueService;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SoapServer;

class SoapController extends Controller
{
    protected $server;
    protected $queueService;
    protected $initialQueueSize;
    protected $ticket;

    public function __construct()
    {
        $options = [
            'uri' => config('qbwc.routes.prefix'),
            'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
        ];

        $this->server = new SoapServer(config('qbwc.soap.wsdl'), $options);
    }

    public function handle($queueName = null)
    {
        try {
            $this->queueService = new QueueService($queueName);
            $this->queueService->initializeQueue();
            $this->initialQueueSize = $this->queueService->getInitialQueueSize();

            $this->server->setObject($this);

            ob_start();
            $this->server->handle();
            $response = ob_get_clean();

            return response($response, 200)->header('Content-Type', 'text/xml; charset=UTF-8');
        } catch (\Exception $e) {
            Log::error("Failed to handle SOAP request: " . $e->getMessage());
            return response('', 200)->header('Content-Type', 'text/xml; charset=UTF-8');
        }
    }

    public function serverVersion()
    {
        try {
            $version = new ServerVersion(config('qbwc.soap.version'));
            return new ServerVersionResponse($version->getStrVersion());
        } catch (\Exception $e) {
            Log::error("Failed to get server version: " . $e->getMessage());
            return $this->sendEmptyResponse(ServerVersionResponse::class);
        }
    }

    public function clientVersion($parameters)
    {
        try {
            return new ClientVersionResponse('O:' . $parameters->getStrVersion());
        } catch (\Exception $e) {
            Log::error("Failed to get client version: " . $e->getMessage());
            return $this->sendEmptyResponse(ClientVersionResponse::class);
        }
    }

    public function authenticate($parameters)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error("Failed to authenticate: " . $e->getMessage());
            return new AuthenticateResponse(new ArrayOfString(['', 'nvu']));
        }
    }

    public function sendRequestXML($parameters)
    {
        if (!$this->validateTicket($parameters->getTicket())) {
            return $this->handleInvalidTicket(SendRequestXMLResponse::class);
        }

        try {
            $task = $this->queueService->getNextTask();
            $query = null;

            if ($task) {
                $taskClass = $task->getTaskClassAttribute();
                $taskParams = $task->getTaskParamsAttribute();
                $taskInstance = new $taskClass(...$taskParams); 
                $query = $taskInstance->toQbXml();
            }

            return is_null($query) ?
                $this->sendEmptyResponse(SendRequestXMLResponse::class) :
                new SendRequestXMLResponse($query);
        } catch (\Exception $e) {
            Log::error("Failed to send request XML: " . $e->getMessage());
            return $this->sendEmptyResponse(SendRequestXMLResponse::class);
        }
    }

    public function receiveResponseXML($parameters)
    {
        if (!$this->validateTicket($parameters->getTicket())) {
            return $this->handleInvalidTicket(ReceiveResponseXMLResponse::class);
        }

        try {
            $responseXML = $parameters->getResponse();

            $parsedData = $this->parseResponseXML($responseXML);
            $response = $parsedData->QBXMLMsgsRs;

            $callbackClass = $this->getCallbackClass($response);

            if ($callbackClass && class_exists($callbackClass)) {
                $callback = new $callbackClass();
                $callback->handleResponse($response);
            }

            $percentComplete = 100;

            $task = $this->queueService->getNextTask();

            if ($task) {
                $this->queueService->markTaskCompleted($task);
                $percentComplete = $this->queueService->getPercentComplete();
            }

            return new ReceiveResponseXMLResponse($percentComplete);
        } catch (\Exception $e) {
            Log::error("Failed to receive response XML: " . $e->getMessage());
            return $this->sendEmptyResponse(ReceiveResponseXMLResponse::class);
        }
    }

    public function connectionError($parameters)
    {
        if (!$this->validateTicket($parameters->getTicket())) {
            return $this->handleInvalidTicket(ConnectionErrorResponse::class);
        }

        try {
            $response = "Ticket: {$parameters->getTicket()} | ";
            $response .= "Hresult: {$parameters->getHresult()} | ";
            $response .= "Message: {$parameters->getMessage()}";

            return new ConnectionErrorResponse($response);
        } catch (\Exception $e) {
            Log::error("Connection error: " . $e->getMessage());
            return $this->sendEmptyResponse(ConnectionErrorResponse::class);
        }
    }

    public function getLastError($parameters)
    {
        if (!$this->validateTicket($parameters->getTicket())) {
            return $this->handleInvalidTicket(GetLastErrorResponse::class);
        }

        try {
            $response = "Ticket: {$parameters->getTicket()} | ";
            $response .= "Hresult: {$parameters->getHresult()} | ";
            $response .= "Message: {$parameters->getMessage()}";

            return new GetLastErrorResponse($response);
        } catch (\Exception $e) {
            Log::error("Failed to get last error: " . $e->getMessage());
            return $this->sendEmptyResponse(GetLastErrorResponse::class);
        }
    }

    public function closeConnection($parameters)
    {
        if (!$this->validateTicket($parameters->getTicket())) {
            return $this->handleInvalidTicket(CloseConnectionResponse::class);
        }

        try {
            $this->queueService->markQueueCompleted();
            return new CloseConnectionResponse("Update Complete | Queue ID: {$this->queueService->getQueueId()}");
        } catch (\Exception $e) {
            Log::error("Failed to close connection: " . $e->getMessage());
            return $this->sendEmptyResponse(CloseConnectionResponse::class);
        }
    }

    private function generateTicket()
    {
        $this->ticket = config('qbwc.soap.ticket_prefix') . Str::random();
    }

    private function validateTicket($ticket)
    {
        return $ticket == $this->ticket;
    }

    private function handleInvalidTicket($responseClass)
    {
        Log::error("Invalid ticket");
        return $this->sendEmptyResponse($responseClass);
    }

    private function parseResponseXML($xml)
    {
        return simplexml_load_string($xml);
    }

    private function sendEmptyResponse($responseClass)
    {
        $baseQuery = new QbxmlQuery();
        $query = $baseQuery->emptyResponse();

        return new $responseClass($query);
    }

    private function getCallbackClass($data)
    {
        $callbackMap = config('qbwc.callback_map');

        foreach ($callbackMap as $responseType => $callbackClass) {
            if (isset($data->$responseType)) {
                return $callbackClass;
            }
        }

        return null;
    }
}
