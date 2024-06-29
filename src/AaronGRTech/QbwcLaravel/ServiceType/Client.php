<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Client ServiceType
 * @subpackage Services
 */
class Client extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named clientVersion
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\ClientVersion $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\ClientVersionResponse|bool
     */
    public function clientVersion(\AaronGRTech\QbwcLaravel\StructType\ClientVersion $parameters)
    {
        try {
            $this->setResult($resultClientVersion = $this->getSoapClient()->__soapCall('clientVersion', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultClientVersion;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\ClientVersionResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
