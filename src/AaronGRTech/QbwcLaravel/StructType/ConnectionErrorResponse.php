<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for connectionErrorResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ConnectionErrorResponse extends AbstractStructBase
{
    /**
     * The connectionErrorResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $connectionErrorResult = null;
    /**
     * Constructor method for connectionErrorResponse
     * @uses ConnectionErrorResponse::setConnectionErrorResult()
     * @param string $connectionErrorResult
     */
    public function __construct(?string $connectionErrorResult = null)
    {
        $this
            ->setConnectionErrorResult($connectionErrorResult);
    }
    /**
     * Get connectionErrorResult value
     * @return string|null
     */
    public function getConnectionErrorResult(): ?string
    {
        return $this->connectionErrorResult;
    }
    /**
     * Set connectionErrorResult value
     * @param string $connectionErrorResult
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionErrorResponse
     */
    public function setConnectionErrorResult(?string $connectionErrorResult = null): self
    {
        // validation for constraint: string
        if (!is_null($connectionErrorResult) && !is_string($connectionErrorResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($connectionErrorResult, true), gettype($connectionErrorResult)), __LINE__);
        }
        $this->connectionErrorResult = $connectionErrorResult;
        
        return $this;
    }
}
