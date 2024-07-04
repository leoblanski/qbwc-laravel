<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class SalesReceiptQuery extends QbxmlQuery
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
