<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for closeConnectionResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class CloseConnectionResponse extends AbstractStructBase
{
    /**
     * The closeConnectionResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $closeConnectionResult = null;
    /**
     * Constructor method for closeConnectionResponse
     * @uses CloseConnectionResponse::setCloseConnectionResult()
     * @param string $closeConnectionResult
     */
    public function __construct(?string $closeConnectionResult = null)
    {
        $this
            ->setCloseConnectionResult($closeConnectionResult);
    }
    /**
     * Get closeConnectionResult value
     * @return string|null
     */
    public function getCloseConnectionResult(): ?string
    {
        return $this->closeConnectionResult;
    }
    /**
     * Set closeConnectionResult value
     * @param string $closeConnectionResult
     * @return \AaronGRTech\QbwcLaravel\StructType\CloseConnectionResponse
     */
    public function setCloseConnectionResult(?string $closeConnectionResult = null): self
    {
        // validation for constraint: string
        if (!is_null($closeConnectionResult) && !is_string($closeConnectionResult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($closeConnectionResult, true), gettype($closeConnectionResult)), __LINE__);
        }
        $this->closeConnectionResult = $closeConnectionResult;
        
        return $this;
    }
}
