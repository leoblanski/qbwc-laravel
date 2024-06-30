<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class SalesReceiptQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'SalesReceiptQueryRq';
    }

    protected function getResponseElement()
    {
        return 'SalesReceiptQueryRs';
    }
}
