<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Connection ServiceType
 * @subpackage Services
 */
class Connection extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named connectionError
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\ConnectionError $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionErrorResponse|bool
     */
    public function connectionError(\AaronGRTech\QbwcLaravel\StructType\ConnectionError $parameters)
    {
        try {
            $this->setResult($resultConnectionError = $this->getSoapClient()->__soapCall('connectionError', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultConnectionError;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\ConnectionErrorResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
