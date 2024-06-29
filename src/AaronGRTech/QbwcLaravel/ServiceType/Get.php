<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Get ServiceType
 * @subpackage Services
 */
class Get extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named getLastError
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\GetLastError $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\GetLastErrorResponse|bool
     */
    public function _getLastError(\AaronGRTech\QbwcLaravel\StructType\GetLastError $parameters)
    {
        try {
            $this->setResult($resultGetLastError = $this->getSoapClient()->__soapCall('getLastError', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultGetLastError;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\GetLastErrorResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
