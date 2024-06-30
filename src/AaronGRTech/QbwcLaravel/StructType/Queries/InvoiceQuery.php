<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class InvoiceQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'InvoiceQueryRq';
    }

    protected function getResponseElement()
    {
        return 'InvoiceQueryRs';
    }
}
