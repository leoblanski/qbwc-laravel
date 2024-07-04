<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for serverVersionResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ServerVersionResponse extends AbstractStructBase
{
    /**
     * The serverVersionResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $serverVersionResult = null;
    /**
     * Constructor method for serverVersionResponse
     * @uses ServerVersionResponse::setServerVersionResult()
     * @param string $serverVersionResult
     */
    public function __construct(?string $serverVersionResult = null)
    {
        $this
            ->setServerVersionResult($serverVersionResult);
    }
    /**
     * Get serverVersionResult value
     * @return string|null
     */
    public function getServerVersionResult(): ?string
    {
        return $this->serverVersionResult;
    }
    /**
     * Set serverVersionResult value
     * @param string $serverVersionResult
     * @return \AaronGRTech\QbwcLaravel\StructType\ServerVersionResponse
     */
    public function setServerVersionResult(?string $serverVersionResult = null): self
    {
        // validation for constraint: string
        if (!is_null($serverVersionResult) && !is_string($serverVersionResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($serverVersionResult, true), gettype($serverVersionResult)), __LINE__);
        }
        $this->serverVersionResult = $serverVersionResult;
        
        return $this;
    }
}
