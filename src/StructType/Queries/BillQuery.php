<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class BillQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'BillQueryRq';
    }

    protected function getResponseElement()
    {
        return 'BillQueryRs';
    }
}
