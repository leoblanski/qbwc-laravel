<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

use DOMDocument;
use WsdlToPhp\PackageBase\AbstractStructBase;
use AaronGRTech\QbwcLaravel\Queue\QbQueryQueue;

class QbxmlQuery extends AbstractStructBase
{
    protected $parameters;
    protected $responseOptions;
    protected $innerXml;

    public function __construct(array $parameters = [], array $responseOptions = null, $autoQueue = false)
    {
        $this->parameters = $parameters ?: ['MaxReturned' => 100];
        $this->responseOptions = $responseOptions;
        $this->setInnerXml($this->createInnerXml());

        if ($autoQueue) {
            $this->addToQueue();
        }
    }

    protected function setInnerXml(DOMDocument $innerXml)
    {
        $this->innerXml = $innerXml;
    }

    public function toQbxml()
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $xml->appendChild($xml->createProcessingInstruction('qbxml', 'version="16.0"'));

        $qbXML = $xml->createElement('QBXML');
        $xml->appendChild($qbXML);

        $qbXMLMsgsRq = $xml->createElement('QBXMLMsgsRq');
        $qbXMLMsgsRq->setAttribute('onError', 'stopOnError');
        $qbXML->appendChild($qbXMLMsgsRq);

        $importedInnerXml = $xml->importNode($this->innerXml->documentElement, true);
        $qbXMLMsgsRq->appendChild($importedInnerXml);

        if ($this->responseOptions !== null) {
            $responseElement = $this->createResponseOptions($xml);
            $qbXML->appendChild($responseElement);
        }

        return $xml->saveXML();
    }

    public function addToQueue()
    {
        app(QbQueryQueue::class)->addQuery($this->toQbxml());
    }

    protected function createInnerXml()
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $queryRq = $xml->createElement($this->getQueryElement());

        foreach ($this->parameters as $key => $value) {
            $this->appendParameter($xml, $queryRq, $key, $value);
        }

        $xml->appendChild($queryRq);

        return $xml;
    }

    protected function appendParameter(DOMDocument $xml, \DOMElement $parent, $key, $value)
    {
        if (is_array($value)) {
            $element = $xml->createElement($key);
            foreach ($value as $subKey => $subValue) {
                $this->appendParameter($xml, $element, $subKey, $subValue);
            }
            $parent->appendChild($element);
        } else {
            $parent->appendChild($xml->createElement($key, $value));
        }
    }

    protected function createResponseOptions(DOMDocument $xml)
    {
        $responseElementName = $this->getResponseElement();
        $responseElement = $xml->createElement($responseElementName);

        foreach ($this->responseOptions as $key => $value) {
            $responseElement->setAttribute($key, $value);
        }

        return $responseElement;
    }

    protected function getQueryElement()
    {
        return 'QueryRq';
    }

    protected function getResponseElement()
    {
        return 'QueryRs';
    }
}
