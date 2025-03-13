<?php

namespace RegalWings\QbwcLaravel\Http\Controllers;

use RegalWings\QbwcLaravel\ArrayType\ArrayOfString;
use RegalWings\QbwcLaravel\Services\QueueService;
use RegalWings\QbwcLaravel\Services\SoapService;
use RegalWings\QbwcLaravel\StructType\AuthenticateResponse;
use RegalWings\QbwcLaravel\StructType\ClientVersionResponse;
use RegalWings\QbwcLaravel\StructType\CloseConnectionResponse;
use RegalWings\QbwcLaravel\StructType\ConnectionErrorResponse;
use RegalWings\QbwcLaravel\StructType\GetLastErrorResponse;
use RegalWings\QbwcLaravel\StructType\ReceiveResponseXMLResponse;
use RegalWings\QbwcLaravel\StructType\SendRequestXMLResponse;
use RegalWings\QbwcLaravel\StructType\ServerVersion;
use RegalWings\QbwcLaravel\StructType\ServerVersionResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use SoapServer;

class SoapController extends Controller
{
    protected $server;
    protected $queueName;
    protected $file;
    protected $queueService;
    protected $initialQueueSize;
    protected $soapService;
    protected $ticket;

    public function __construct()
    {
        $options = [
            'uri' => config('qbwc.routes.prefix'),
            'classmap' => \RegalWings\QbwcLaravel\ClassMap::get(),
        ];

        $this->server = new SoapServer(config('qbwc.soap.wsdl'), $options);
        $this->soapService = new SoapService();
        $this->ticket = $this->soapService->getCachedTicket();
    }

    public function handle($queueName = null, $file = null)
    {
        try {
            $this->server->setObject($this);
            $this->queueName = $queueName;
            $this->file = $file;

            if ($this->ticket && $this->queueName) {
                $this->queueService = new QueueService($this->ticket, $this->queueName, $this->file);
                $this->queueService->initializeQueue();
                $this->initialQueueSize = $this->queueService->getInitialQueueSize();
            }

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
            return $this->soapService->sendEmptyResponse(ServerVersionResponse::class);
        }
    }

    public function clientVersion($parameters)
    {
        try {
            return new ClientVersionResponse('O:' . $parameters->getStrVersion());
        } catch (\Exception $e) {
            Log::error("Failed to get client version: " . $e->getMessage());
            return $this->soapService->sendEmptyResponse(ClientVersionResponse::class);
        }
    }

    public function authenticate($parameters)
    {
        try {
            $response = new ArrayOfString(['', 'nvu']);

            if (
                $parameters->getStrUserName() == config('qbwc.user') ||
                $parameters->getStrPassword() == config('qbwc.password')
            ) {
                $this->soapService->generateTicket();
                $this->ticket = $this->soapService->getCachedTicket();
                $this->queueService = new QueueService($this->ticket, $this->queueName, $this->file);
                $this->queueService->initializeQueue();
                $this->initialQueueSize = $this->queueService->getInitialQueueSize();

                $filePath = '';
                if ($this->file) {
                    $filePath = config("qbwc.files.{$this->file}");
                }

                $response = new ArrayOfString([$this->ticket, $filePath]);
            }
            return new AuthenticateResponse($response);
        } catch (\Exception $e) {
            Log::error("Failed to authenticate: " . $e->getMessage());
            return new AuthenticateResponse(new ArrayOfString(['', 'nvu']));
        }
    }

    public function sendRequestXML($parameters)
    {
        if (!$this->soapService->validateTicket($parameters->getTicket())) {
            return $this->soapService->handleInvalidTicket(SendRequestXMLResponse::class);
        }

        try {
            $taskQuery = $this->queueService->getNextTask();
            $query = null;

            if ($taskQuery) {
                $taskQuery = $this->queueService->setRuntimeValues($taskQuery);
                $query = $taskQuery->toQbXml();
            }

            return is_null($query) ?
                $this->soapService->sendEmptyResponse(SendRequestXMLResponse::class) :
                new SendRequestXMLResponse($query);
        } catch (\Exception $e) {
            Log::error("Failed to send request XML: " . $e->getMessage());
            return $this->soapService->sendEmptyResponse(SendRequestXMLResponse::class);
        }
    }

    public function receiveResponseXML($parameters)
    {
        if (!$this->soapService->validateTicket($parameters->getTicket())) {
            return $this->soapService->handleInvalidTicket(ReceiveResponseXMLResponse::class, 0);
        }

        try {
            $responseXML = $parameters->getResponse();

            $parsedData = $this->soapService->parseResponseXML($responseXML);
            $response = $parsedData->QBXMLMsgsRs;

            $iteratorId = $response?->children()?->attributes()?->iteratorID?->__toString();
            $iteratorRemainingCount = $response?->children()?->attributes()?->iteratorRemainingCount?->__toString();

            if ($iteratorId && $iteratorRemainingCount >= 0) {
                $this->queueService->updateTaskIterator($iteratorId, $iteratorRemainingCount);
            }

            $callbackClass = $this->soapService->getCallbackClass($response);

            if ($callbackClass && class_exists($callbackClass)) {
                $callback = new $callbackClass();
                $callback->handleResponse($response, $this->file);
            }

            $task = $this->queueService->getCurrentTask();

            if ($task && $task->iterator != 'Continue') {
                $this->queueService->markTaskCompleted($task);
            }

            $percentComplete = $this->queueService->getPercentComplete();

            return new ReceiveResponseXMLResponse($percentComplete);
        } catch (\Exception $e) {
            Log::error("Failed to receive response XML: " . $e->getMessage());
            return new ReceiveResponseXMLResponse(0);
        }
    }

    public function connectionError($parameters)
    {
        if (!$this->soapService->validateTicket($parameters->getTicket())) {
            return $this->soapService->handleInvalidTicket(ConnectionErrorResponse::class);
        }

        try {
            $response = "Ticket: {$parameters->getTicket()} | ";
            $response .= "Hresult: {$parameters->hresult()} | ";
            $response .= "Message: {$parameters->getMessage()}";

            $this->queueService->markQueueFailed();
            $this->soapService->forgetCachedTicket();

            return new ConnectionErrorResponse($response);
        } catch (\Exception $e) {
            Log::error("Connection error: " . $e->getMessage());
            return $this->soapService->sendEmptyResponse(ConnectionErrorResponse::class);
        }
    }

    public function getLastError($parameters)
    {
        if (!$this->soapService->validateTicket($parameters->getTicket())) {
            return $this->soapService->handleInvalidTicket(GetLastErrorResponse::class);
        }

        try {
            $response = "Ticket: {$parameters->getTicket()}";

            $this->queueService->markQueueFailed();
            $this->soapService->forgetCachedTicket();

            return new GetLastErrorResponse($response);
        } catch (\Exception $e) {
            Log::error("Failed to get last error: " . $e->getMessage());
            return $this->soapService->sendEmptyResponse(GetLastErrorResponse::class);
        }
    }

    public function closeConnection($parameters)
    {
        if (!$this->soapService->validateTicket($parameters->getTicket())) {
            return $this->soapService->handleInvalidTicket(CloseConnectionResponse::class);
        }

        try {
            $this->queueService->markQueueCompleted();
            $this->soapService->forgetCachedTicket();
            return new CloseConnectionResponse("Update Complete | Queue ID: {$this->queueService->getQueueId()}");
        } catch (\Exception $e) {
            Log::error("Failed to close connection: " . $e->getMessage());
            return $this->soapService->sendEmptyResponse(CloseConnectionResponse::class);
        }
    }
}
