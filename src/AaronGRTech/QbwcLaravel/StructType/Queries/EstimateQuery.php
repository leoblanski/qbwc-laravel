<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class EstimateQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'EstimateQueryRq';
    }

    protected function getResponseElement()
    {
        return 'EstimateQueryRs';
    }
}
