<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class CheckQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'CheckQueryRq';
    }

    protected function getResponseElement()
    {
        return 'CheckQueryRs';
    }
}
