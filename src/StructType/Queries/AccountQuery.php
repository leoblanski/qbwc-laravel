<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class AccountQuery extends QbxmlQuery
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
