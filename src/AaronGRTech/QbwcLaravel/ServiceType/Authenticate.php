<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Authenticate ServiceType
 * @subpackage Services
 */
class Authenticate extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named authenticate
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\Authenticate $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\AuthenticateResponse|bool
     */
    public function authenticate(\AaronGRTech\QbwcLaravel\StructType\Authenticate $parameters)
    {
        try {
            $this->setResult($resultAuthenticate = $this->getSoapClient()->__soapCall('authenticate', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultAuthenticate;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\AuthenticateResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
