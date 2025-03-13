<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class EmployeeQuery extends QbxmlQuery
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
