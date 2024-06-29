<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel\ServiceType;

use SoapFault;
use WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Receive ServiceType
 * @subpackage Services
 */
class Receive extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named receiveResponseXML
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXML $parameters
     * @return \AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXMLResponse|bool
     */
    public function receiveResponseXML(\AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXML $parameters)
    {
        try {
            $this->setResult($resultReceiveResponseXML = $this->getSoapClient()->__soapCall('receiveResponseXML', [
                $parameters,
            ], [], [], $this->outputHeaders));
        
            return $resultReceiveResponseXML;
        } catch (SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
        
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \AaronGRTech\QbwcLaravel\StructType\ReceiveResponseXMLResponse
     */
    public function getResult()
    {
        return parent::getResult();
    }
}
