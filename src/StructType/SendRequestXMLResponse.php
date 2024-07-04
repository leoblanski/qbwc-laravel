<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for sendRequestXMLResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class SendRequestXMLResponse extends AbstractStructBase
{
    /**
     * The sendRequestXMLResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $sendRequestXMLResult = null;
    /**
     * Constructor method for sendRequestXMLResponse
     * @uses SendRequestXMLResponse::setSendRequestXMLResult()
     * @param string $sendRequestXMLResult
     */
    public function __construct(?string $sendRequestXMLResult = null)
    {
        $this
            ->setSendRequestXMLResult($sendRequestXMLResult);
    }
    /**
     * Get sendRequestXMLResult value
     * @return string|null
     */
    public function getSendRequestXMLResult(): ?string
    {
        return $this->sendRequestXMLResult;
    }
    /**
     * Set sendRequestXMLResult value
     * @param string $sendRequestXMLResult
     * @return \AaronGRTech\QbwcLaravel\StructType\SendRequestXMLResponse
     */
    public function setSendRequestXMLResult(?string $sendRequestXMLResult = null): self
    {
        // validation for constraint: string
        if (!is_null($sendRequestXMLResult) && !is_string($sendRequestXMLResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($sendRequestXMLResult, true), gettype($sendRequestXMLResult)), __LINE__);
        }
        $this->sendRequestXMLResult = $sendRequestXMLResult;
        
        return $this;
    }
}
