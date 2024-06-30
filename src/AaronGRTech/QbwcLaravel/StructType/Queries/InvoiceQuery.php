<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class InvoiceQuery extends QbxmlQuery
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
