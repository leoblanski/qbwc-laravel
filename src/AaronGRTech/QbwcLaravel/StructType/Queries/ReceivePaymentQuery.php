<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class ReceivePaymentQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'ReceivePaymentQueryRq';
    }

    protected function getResponseElement()
    {
        return 'ReceivePaymentQueryRs';
    }
}
