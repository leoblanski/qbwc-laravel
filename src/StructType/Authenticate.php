<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for authenticate StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class Authenticate extends AbstractStructBase
{
    /**
     * The strUserName
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $strUserName = null;
    /**
     * The strPassword
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $strPassword = null;
    /**
     * Constructor method for authenticate
     * @uses Authenticate::setStrUserName()
     * @uses Authenticate::setStrPassword()
     * @param string $strUserName
     * @param string $strPassword
     */
    public function __construct(?string $strUserName = null, ?string $strPassword = null)
    {
        $this
            ->setStrUserName($strUserName)
            ->setStrPassword($strPassword);
    }
    /**
     * Get strUserName value
     * @return string|null
     */
    public function getStrUserName(): ?string
    {
        return $this->strUserName;
    }
    /**
     * Set strUserName value
     * @param string $strUserName
     * @return \AaronGRTech\QbwcLaravel\StructType\Authenticate
     */
    public function setStrUserName(?string $strUserName = null): self
    {
        // validation for constraint: string
        if (!is_null($strUserName) && !is_string($strUserName)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($strUserName, true), gettype($strUserName)), __LINE__);
        }
        $this->strUserName = $strUserName;
        
        return $this;
    }
    /**
     * Get strPassword value
     * @return string|null
     */
    public function getStrPassword(): ?string
    {
        return $this->strPassword;
    }
    /**
     * Set strPassword value
     * @param string $strPassword
     * @return \AaronGRTech\QbwcLaravel\StructType\Authenticate
     */
    public function setStrPassword(?string $strPassword = null): self
    {
        // validation for constraint: string
        if (!is_null($strPassword) && !is_string($strPassword)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($strPassword, true), gettype($strPassword)), __LINE__);
        }
        $this->strPassword = $strPassword;
        
        return $this;
    }
}
