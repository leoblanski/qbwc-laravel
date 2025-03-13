<?php

declare(strict_types=1);

namespace RegalWings\QbwcLaravel\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for closeConnection StructType
 * @subpackage Structs
 */
#[\AllowDynamicProperties]
class CloseConnection extends AbstractStructBase
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
     * Constructor method for closeConnection
     * @uses CloseConnection::setTicket()
     * @param string $ticket
     */
    public function __construct(?string $ticket = null)
    {
        $this
            ->setTicket($ticket);
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
     * @return \RegalWings\QbwcLaravel\StructType\CloseConnection
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
}
