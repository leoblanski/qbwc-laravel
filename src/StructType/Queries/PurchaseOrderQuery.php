<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class PurchaseOrderQuery extends QbxmlQuery
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
