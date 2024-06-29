<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for clientVersionResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ClientVersionResponse extends AbstractStructBase
{
    /**
     * The clientVersionResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $clientVersionResult = null;
    /**
     * Constructor method for clientVersionResponse
     * @uses ClientVersionResponse::setClientVersionResult()
     * @param string $clientVersionResult
     */
    public function __construct(?string $clientVersionResult = null)
    {
        $this
            ->setClientVersionResult($clientVersionResult);
    }
    /**
     * Get clientVersionResult value
     * @return string|null
     */
    public function getClientVersionResult(): ?string
    {
        return $this->clientVersionResult;
    }
    /**
     * Set clientVersionResult value
     * @param string $clientVersionResult
     * @return \AaronGRTech\QbwcLaravel\StructType\ClientVersionResponse
     */
    public function setClientVersionResult(?string $clientVersionResult = null): self
    {
        // validation for constraint: string
        if (!is_null($clientVersionResult) && !is_string($clientVersionResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($clientVersionResult, true), gettype($clientVersionResult)), __LINE__);
        }
        $this->clientVersionResult = $clientVersionResult;
        
        return $this;
    }
}
