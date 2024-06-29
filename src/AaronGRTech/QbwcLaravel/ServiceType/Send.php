<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Send ServiceType
 * @subpackage Services
 */
class Send extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named sendRequestXML
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\SendRequestXML $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\SendRequestXMLResponse|bool
     */
    public function sendRequestXML(\AaronGRTech\QbwcLaravel\StructType\SendRequestXML $parameters)
    {
        try {
            $this->setResult($resultSendRequestXML = $this->getSoapClient()->__soapCall('sendRequestXML', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultSendRequestXML;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\SendRequestXMLResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
