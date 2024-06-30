<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class AccountQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'AccountQueryRq';
    }

    protected function getResponseElement()
    {
        return 'AccountQueryRs';
    }
}
