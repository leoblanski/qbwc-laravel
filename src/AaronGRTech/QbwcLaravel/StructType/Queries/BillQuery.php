<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class BillQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'BillQueryRq';
    }

    protected function getResponseElement()
    {
        return 'BillQueryRs';
    }
}
