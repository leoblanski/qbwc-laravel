<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Server ServiceType
 * @subpackage Services
 */
class Server extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named serverVersion
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\ServerVersion $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\ServerVersionResponse|bool
     */
    public function serverVersion(\AaronGRTech\QbwcLaravel\StructType\ServerVersion $parameters)
    {
            $this->setResult($parameters);
        
            return $parameters;
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\ServerVersionResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
