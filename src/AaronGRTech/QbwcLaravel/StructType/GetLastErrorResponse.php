<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for getLastErrorResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class GetLastErrorResponse extends AbstractStructBase
{
    /**
     * The getLastErrorResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $getLastErrorResult = null;
    /**
     * Constructor method for getLastErrorResponse
     * @uses GetLastErrorResponse::setGetLastErrorResult()
     * @param string $getLastErrorResult
     */
    public function __construct(?string $getLastErrorResult = null)
    {
        $this
            ->setGetLastErrorResult($getLastErrorResult);
    }
    /**
     * Get getLastErrorResult value
     * @return string|null
     */
    public function getGetLastErrorResult(): ?string
    {
        return $this->getLastErrorResult;
    }
    /**
     * Set getLastErrorResult value
     * @param string $getLastErrorResult
     * @return \AaronGRTech\QbwcLaravel\StructType\GetLastErrorResponse
     */
    public function setGetLastErrorResult(?string $getLastErrorResult = null): self
    {
        // validation for constraint: string
        if (!is_null($getLastErrorResult) && !is_string($getLastErrorResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($getLastErrorResult, true), gettype($getLastErrorResult)), __LINE__);
        }
        $this->getLastErrorResult = $getLastErrorResult;
        
        return $this;
    }
}
