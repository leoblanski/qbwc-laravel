<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class CustomerQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'CustomerQueryRq';
    }

    protected function getResponseElement()
    {
        return 'CustomerQueryRs';
    }
}
