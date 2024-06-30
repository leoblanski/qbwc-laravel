<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class VendorQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'VendorQueryRq';
    }

    protected function getResponseElement()
    {
        return 'VendorQueryRs';
    }
}
