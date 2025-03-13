<?php

declare(strict_types=1);

namespace RegalWings\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for sendRequestXML StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class SendRequestXML extends AbstractStructBase
{
    /**
     * The qbXMLMajorVers
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var int
     */
    protected int $qbXMLMajorVers;
    /**
     * The qbXMLMinorVers
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var int
     */
    protected int $qbXMLMinorVers;
    /**
     * The ticket
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $ticket = null;
    /**
     * The strHCPResponse
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $strHCPResponse = null;
    /**
     * The strCompanyFileName
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $strCompanyFileName = null;
    /**
     * The qbXMLCountry
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $qbXMLCountry = null;
    /**
     * Constructor method for sendRequestXML
     * @uses SendRequestXML::setQbXMLMajorVers()
     * @uses SendRequestXML::setQbXMLMinorVers()
     * @uses SendRequestXML::setTicket()
     * @uses SendRequestXML::setStrHCPResponse()
     * @uses SendRequestXML::setStrCompanyFileName()
     * @uses SendRequestXML::setQbXMLCountry()
     * @param int $qbXMLMajorVers
     * @param int $qbXMLMinorVers
     * @param string $ticket
     * @param string $strHCPResponse
     * @param string $strCompanyFileName
     * @param string $qbXMLCountry
     */
    public function __construct(int $qbXMLMajorVers, int $qbXMLMinorVers, ?string $ticket = null, ?string $strHCPResponse = null, ?string $strCompanyFileName = null, ?string $qbXMLCountry = null)
    {
        $this
            ->setQbXMLMajorVers($qbXMLMajorVers)
            ->setQbXMLMinorVers($qbXMLMinorVers)
            ->setTicket($ticket)
            ->setStrHCPResponse($strHCPResponse)
            ->setStrCompanyFileName($strCompanyFileName)
            ->setQbXMLCountry($qbXMLCountry);
    }
    /**
     * Get qbXMLMajorVers value
     * @return int
     */
    public function getQbXMLMajorVers(): int
    {
        return $this->qbXMLMajorVers;
    }
    /**
     * Set qbXMLMajorVers value
     * @param int $qbXMLMajorVers
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setQbXMLMajorVers(int $qbXMLMajorVers): self
    {
        // validation for constraint: int
        if (!is_null($qbXMLMajorVers) && !(is_int($qbXMLMajorVers) || ctype_digit($qbXMLMajorVers))) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide an integer value, %s given', var_export($qbXMLMajorVers, true), gettype($qbXMLMajorVers)), __LINE__);
        }
        $this->qbXMLMajorVers = $qbXMLMajorVers;

        return $this;
    }
    /**
     * Get qbXMLMinorVers value
     * @return int
     */
    public function getQbXMLMinorVers(): int
    {
        return $this->qbXMLMinorVers;
    }
    /**
     * Set qbXMLMinorVers value
     * @param int $qbXMLMinorVers
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setQbXMLMinorVers(int $qbXMLMinorVers): self
    {
        // validation for constraint: int
        if (!is_null($qbXMLMinorVers) && !(is_int($qbXMLMinorVers) || ctype_digit($qbXMLMinorVers))) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide an integer value, %s given', var_export($qbXMLMinorVers, true), gettype($qbXMLMinorVers)), __LINE__);
        }
        $this->qbXMLMinorVers = $qbXMLMinorVers;

        return $this;
    }
    /**
     * Get ticket value
     * @return string|null
     */
    public function getTicket(): ?string
    {
        return $this->ticket;
    }
    /**
     * Set ticket value
     * @param string $ticket
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setTicket(?string $ticket = null): self
    {
        // validation for constraint: string
        if (!is_null($ticket) && !is_string($ticket)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($ticket, true), gettype($ticket)), __LINE__);
        }
        $this->ticket = $ticket;

        return $this;
    }
    /**
     * Get strHCPResponse value
     * @return string|null
     */
    public function getStrHCPResponse(): ?string
    {
        return $this->strHCPResponse;
    }
    /**
     * Set strHCPResponse value
     * @param string $strHCPResponse
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setStrHCPResponse(?string $strHCPResponse = null): self
    {
        // validation for constraint: string
        if (!is_null($strHCPResponse) && !is_string($strHCPResponse)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($strHCPResponse, true), gettype($strHCPResponse)), __LINE__);
        }
        $this->strHCPResponse = $strHCPResponse;

        return $this;
    }
    /**
     * Get strCompanyFileName value
     * @return string|null
     */
    public function getStrCompanyFileName(): ?string
    {
        return $this->strCompanyFileName;
    }
    /**
     * Set strCompanyFileName value
     * @param string $strCompanyFileName
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setStrCompanyFileName(?string $strCompanyFileName = null): self
    {
        // validation for constraint: string
        if (!is_null($strCompanyFileName) && !is_string($strCompanyFileName)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($strCompanyFileName, true), gettype($strCompanyFileName)), __LINE__);
        }
        $this->strCompanyFileName = $strCompanyFileName;

        return $this;
    }
    /**
     * Get qbXMLCountry value
     * @return string|null
     */
    public function getQbXMLCountry(): ?string
    {
        return $this->qbXMLCountry;
    }
    /**
     * Set qbXMLCountry value
     * @param string $qbXMLCountry
     * @return \RegalWings\QbwcLaravel\StructType\SendRequestXML
     */
    public function setQbXMLCountry(?string $qbXMLCountry = null): self
    {
        // validation for constraint: string
        if (!is_null($qbXMLCountry) && !is_string($qbXMLCountry)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($qbXMLCountry, true), gettype($qbXMLCountry)), __LINE__);
        }
        $this->qbXMLCountry = $qbXMLCountry;

        return $this;
    }
}
