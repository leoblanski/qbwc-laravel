<?php

declare(strict_types=1);

namespace RegalWings\QbwcLaravel\StructType;

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
     * @var \RegalWings\QbwcLaravel\ArrayType\ArrayOfString|null
     */
    protected ?\RegalWings\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null;
    /**
     * Constructor method for authenticateResponse
     * @uses AuthenticateResponse::setAuthenticateResult()
     * @param \RegalWings\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult
     */
    public function __construct(?\RegalWings\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null)
    {
        $this
            ->setAuthenticateResult($authenticateResult);
    }
    /**
     * Get authenticateResult value
     * @return \RegalWings\QbwcLaravel\ArrayType\ArrayOfString|null
     */
    public function getAuthenticateResult(): ?\RegalWings\QbwcLaravel\ArrayType\ArrayOfString
    {
        return $this->authenticateResult;
    }
    /**
     * Set authenticateResult value
     * @param \RegalWings\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult
     * @return \RegalWings\QbwcLaravel\StructType\AuthenticateResponse
     */
    public function setAuthenticateResult(?\RegalWings\QbwcLaravel\ArrayType\ArrayOfString $authenticateResult = null): self
    {
        $this->authenticateResult = $authenticateResult;

        return $this;
    }
}
