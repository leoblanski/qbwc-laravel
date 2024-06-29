<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Close ServiceType
 * @subpackage Services
 */
class Close extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named closeConnection
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\CloseConnection $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\CloseConnectionResponse|bool
     */
    public function closeConnection(\AaronGRTech\QbwcLaravel\StructType\CloseConnection $parameters)
    {
        try {
            $this->setResult($resultCloseConnection = $this->getSoapClient()->__soapCall('closeConnection', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultCloseConnection;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\CloseConnectionResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
