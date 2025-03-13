<?php

declare(strict_types=1);

namespace RegalWings\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for receiveResponseXMLResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ReceiveResponseXMLResponse extends AbstractStructBase
{
    /**
     * The receiveResponseXMLResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var int
     */
    protected int $receiveResponseXMLResult;
    /**
     * Constructor method for receiveResponseXMLResponse
     * @uses ReceiveResponseXMLResponse::setReceiveResponseXMLResult()
     * @param int $receiveResponseXMLResult
     */
    public function __construct(int $receiveResponseXMLResult)
    {
        $this
            ->setReceiveResponseXMLResult($receiveResponseXMLResult);
    }
    /**
     * Get receiveResponseXMLResult value
     * @return int
     */
    public function getReceiveResponseXMLResult(): int
    {
        return $this->receiveResponseXMLResult;
    }
    /**
     * Set receiveResponseXMLResult value
     * @param int $receiveResponseXMLResult
     * @return \RegalWings\QbwcLaravel\StructType\ReceiveResponseXMLResponse
     */
    public function setReceiveResponseXMLResult(int $receiveResponseXMLResult): self
    {
        // validation for constraint: int
        if (!is_null($receiveResponseXMLResult) && !(is_int($receiveResponseXMLResult) || ctype_digit($receiveResponseXMLResult))) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide an integer value, %s given', var_export($receiveResponseXMLResult, true), gettype($receiveResponseXMLResult)), __LINE__);
        }
        $this->receiveResponseXMLResult = $receiveResponseXMLResult;

        return $this;
    }
}
