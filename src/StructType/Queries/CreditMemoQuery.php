<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class CreditMemoQuery extends QbxmlQuery
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
