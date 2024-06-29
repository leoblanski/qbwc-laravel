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
        try {
            $this->setResult($resultServerVersion = $this->getSoapClient()->__soapCall('serverVersion', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultServerVersion;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
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
