<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for connectionError StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class ConnectionError extends AbstractStructBase
{
    /**
     * The ticket
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $ticket = null;
    /**
     * The hresult
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $hresult = null;
    /**
     * The message
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * @var string|null
     */
    protected ?string $message = null;
    /**
     * Constructor method for connectionError
     * @uses ConnectionError::setTicket()
     * @uses ConnectionError::setHresult()
     * @uses ConnectionError::setMessage()
     * @param string $ticket
     * @param string $hresult
     * @param string $message
     */
    public function __construct(?string $ticket = null, ?string $hresult = null, ?string $message = null)
    {
        $this
            ->setTicket($ticket)
            ->setHresult($hresult)
            ->setMessage($message);
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
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionError
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
     * Get hresult value
     * @return string|null
     */
    public function getHresult(): ?string
    {
        return $this->hresult;
    }
    /**
     * Set hresult value
     * @param string $hresult
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionError
     */
    public function setHresult(?string $hresult = null): self
    {
        // validation for constraint: string
        if (!is_null($hresult) && !is_string($hresult)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($hresult, true), gettype($hresult)), __LINE__);
        }
        $this->hresult = $hresult;
        
        return $this;
    }
    /**
     * Get message value
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
    /**
     * Set message value
     * @param string $message
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionError
     */
    public function setMessage(?string $message = null): self
    {
        // validation for constraint: string
        if (!is_null($message) && !is_string($message)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($message, true), gettype($message)), __LINE__);
        }
        $this->message = $message;
        
        return $this;
    }
}
