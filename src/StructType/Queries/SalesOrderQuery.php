<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class SalesOrderQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'SalesOrderQueryRq';
    }

    protected function getResponseElement()
    {
        return 'SalesOrderQueryRs';
    }
}
