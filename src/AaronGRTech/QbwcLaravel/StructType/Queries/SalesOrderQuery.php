<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class SalesOrderQuery extends QbmxlQuery
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
