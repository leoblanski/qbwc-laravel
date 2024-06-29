<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for authenticateResponse StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class AuthenticateResponse extends AbstractStructBase
{
    /**
     * The authenticateResult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var \AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString|null
     */
    protected ?\AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null;
    /**
     * Constructor method for authenticateResponse
     * @uses AuthenticateResponse::setAuthenticateResult()
     * @param \AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult
     */
    public function __construct(?\AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null)
    {
        $this
            ->setAuthenticateResult($authenticateResult);
    }
    /**
     * Get authenticateResult value
     * @return \AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString|null
     */
    public function getAuthenticateResult(): ?\AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString
    {
        return $this->authenticateResult;
    }
    /**
     * Set authenticateResult value
     * @param \AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult
     * @return \AaronGRTech\QbwcLaravel\StructType\AuthenticateResponse
     */
    public function setAuthenticateResult(?\AaronGRTech\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null): self
    {
        $this->authenticateResult = $authenticateResult;
        
        return $this;
    }
}
