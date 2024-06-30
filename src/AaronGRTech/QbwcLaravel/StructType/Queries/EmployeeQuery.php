<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class EmployeeQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'EmployeeQueryRq';
    }

    protected function getResponseElement()
    {
        return 'EmployeeQueryRs';
    }
}
