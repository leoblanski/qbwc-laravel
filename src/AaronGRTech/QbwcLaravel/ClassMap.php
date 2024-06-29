<?php

declare(strict_types=1);

namespace AaronGRTech\QbwcLaravel;

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
            'authenticate' => '\\AaronGRTech\\QbwcLaravel\\StructType\\Authenticate',
            'authenticateResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\AuthenticateResponse',
            'ArrayOfString' => '\\AaronGRTech\\QbwcLaravel\\ArrayType\\ArrayOfString',
            'serverVersion' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ServerVersion',
            'serverVersionResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ServerVersionResponse',
            'clientVersion' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ClientVersion',
            'clientVersionResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ClientVersionResponse',
            'sendRequestXML' => '\\AaronGRTech\\QbwcLaravel\\StructType\\SendRequestXML',
            'sendRequestXMLResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\SendRequestXMLResponse',
            'receiveResponseXML' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ReceiveResponseXML',
            'receiveResponseXMLResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ReceiveResponseXMLResponse',
            'connectionError' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ConnectionError',
            'connectionErrorResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\ConnectionErrorResponse',
            'getLastError' => '\\AaronGRTech\\QbwcLaravel\\StructType\\GetLastError',
            'getLastErrorResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\GetLastErrorResponse',
            'closeConnection' => '\\AaronGRTech\\QbwcLaravel\\StructType\\CloseConnection',
            'closeConnectionResponse' => '\\AaronGRTech\\QbwcLaravel\\StructType\\CloseConnectionResponse',
        ];
    }
}
