<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

use DOMDocument;
use WsdlToPhp\PackageBase\AbstractStructBase;

class QbxmlQuery extends AbstractStructBase
{
    protected $parameters;
    protected $responseOptions;
    protected $innerXml;
    protected $iterator;
    protected $iteratorId;

    public function __construct(array $parameters = [], array $responseOptions = null, string $requestId = null, string $iterator = null, string $iteratorId = null)
    {
        $this->parameters = $parameters ?: ['MaxReturned' => 100];
        $this->responseOptions = $responseOptions;
        $this->requestId = $requestId;
        $this->iterator = $iterator;
        $this->iteratorId = $iteratorId;
        $this->setInnerXml($this->createInnerXml($requestId, $iterator, $iteratorId));
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameter($keys, $value)
    {
        if (is_array($keys)) {
            $this->setNestedParameter($this->parameters, $keys, $value);
        } else {
            $this->parameters[$keys] = $value;
        }
        $this->setInnerXml($this->createInnerXml($this->requestId, $this->iterator, $this->iteratorId));
    }

    private function setNestedParameter(&$array, $keys, $value)
    {
        $key = array_shift($keys);

        if (!isset($array[$key])) {
            $array[$key] = [];
        }

        if (empty($keys)) {
            $array[$key] = $value;
        } else {
            $this->setNestedParameter($array[$key], $keys, $value);
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

    protected function createInnerXml($requestId, $iterator, $iteratorId)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $queryRq = $xml->createElement($this->getQueryElement());

        if ($requestId) {
            $queryRq->setAttribute('requestID', $requestId);
        }

        if ($iterator) {
            $queryRq->setAttribute('iterator', $iterator);
        }

        if ($iteratorId) {
            $queryRq->setAttribute('iteratorID', $iteratorId);
        }

        foreach ($this->parameters as $key => $value) {
            $this->appendParameter($xml, $queryRq, $key, $value);
        }

        $xml->appendChild($queryRq);

        return $xml;
    }

    protected function appendParameter(DOMDocument $xml, \DOMElement $parent, $key, $value)
    {
        if (is_array($value)) {
            if ($key == 'ListID') {
                foreach ($value as $listId) {
                    $element = $xml->createElement($key);
                    $element->appendChild($xml->createTextNode($listId));
                    $parent->appendChild($element);
                }
                return;
            }

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

    public function emptyResponse()
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $xml->appendChild($xml->createProcessingInstruction('qbxml', 'version="16.0"'));

        $qbXML = $xml->createElement('QBXML');
        $xml->appendChild($qbXML);

        $qbXMLMsgsRq = $xml->createElement('QBXMLMsgsRq');
        $qbXMLMsgsRq->setAttribute('onError', 'stopOnError');
        $qbXML->appendChild($qbXMLMsgsRq);

        return $xml->saveXML();
    }
}
