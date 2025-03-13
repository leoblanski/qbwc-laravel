<?php

declare(strict_types=1);

namespace RegalWings\QbwcLaravel;

/**
 * Class which returns the class map definition
 */
class ClassMap
{
    /**
     * Returns the mapping between the WSDL Structs and generated Structs' classes
     * This array is sent to the \SoapClient when calling the WS
     * @return string[]
     */
    final public static function get(): array
    {
        return [
            'authenticate' => '\\RegalWings\\QbwcLaravel\\StructType\\Authenticate',
            'authenticateResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\AuthenticateResponse',
            'ArrayOfString' => '\\RegalWings\\QbwcLaravel\\ArrayType\\ArrayOfString',
            'serverVersion' => '\\RegalWings\\QbwcLaravel\\StructType\\ServerVersion',
            'serverVersionResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\ServerVersionResponse',
            'clientVersion' => '\\RegalWings\\QbwcLaravel\\StructType\\ClientVersion',
            'clientVersionResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\ClientVersionResponse',
            'sendRequestXML' => '\\RegalWings\\QbwcLaravel\\StructType\\SendRequestXML',
            'sendRequestXMLResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\SendRequestXMLResponse',
            'receiveResponseXML' => '\\RegalWings\\QbwcLaravel\\StructType\\ReceiveResponseXML',
            'receiveResponseXMLResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\ReceiveResponseXMLResponse',
            'connectionError' => '\\RegalWings\\QbwcLaravel\\StructType\\ConnectionError',
            'connectionErrorResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\ConnectionErrorResponse',
            'getLastError' => '\\RegalWings\\QbwcLaravel\\StructType\\GetLastError',
            'getLastErrorResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\GetLastErrorResponse',
            'closeConnection' => '\\RegalWings\\QbwcLaravel\\StructType\\CloseConnection',
            'closeConnectionResponse' => '\\RegalWings\\QbwcLaravel\\StructType\\CloseConnectionResponse',
        ];
    }
}
