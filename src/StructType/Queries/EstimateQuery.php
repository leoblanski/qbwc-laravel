<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class EstimateQuery extends QbxmlQuery
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
