<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class CreditMemoQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'CreditMemoQueryRq';
    }

    protected function getResponseElement()
    {
        return 'CreditMemoQueryRs';
    }
}
