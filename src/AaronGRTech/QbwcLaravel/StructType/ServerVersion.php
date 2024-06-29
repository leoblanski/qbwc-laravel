<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for serverVersion StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ServerVersion extends AbstractStructBase
{
    /**
     * The strVersion
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $strVersion = null;
    /**
     * Constructor method for serverVersion
     * @uses ServerVersion::setStrVersion()
     * @param string $strVersion
     */
    public function __construct(?string $strVersion = null)
    {
        $this
            ->setStrVersion($strVersion ?? config('qbwc.soap.version'));
    }
    /**
     * Get strVersion value
     * @return string|null
     */
    public function getStrVersion(): ?string
    {
        return $this->strVersion;
    }
    /**
     * Set strVersion value
     * @param string $strVersion
     * @return \AaronGRTech\QbwcLaravel\StructType\ServerVersion
     */
    public function setStrVersion(?string $strVersion = null): self
    {
        // validation for constraint: string
        if (!is_null($strVersion) && !is_string($strVersion)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($strVersion, true), gettype($strVersion)), __LINE__);
        }
        $this->strVersion = $strVersion;
        
        return $this;
    }
}
