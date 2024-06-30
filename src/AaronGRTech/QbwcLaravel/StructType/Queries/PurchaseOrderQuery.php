<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class PurchaseOrderQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'PurchaseOrderQueryRq';
    }

    protected function getResponseElement()
    {
        return 'PurchaseOrderQueryRs';
    }
}
