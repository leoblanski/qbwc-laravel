<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class ReceivePaymentQuery extends QbxmlQuery
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
