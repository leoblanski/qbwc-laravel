<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class CustomerQuery extends QbxmlQuery
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
