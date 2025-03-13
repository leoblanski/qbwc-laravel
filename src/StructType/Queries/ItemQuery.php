<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class ItemQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'ItemQueryRq';
    }

    protected function getResponseElement()
    {
        return 'ItemQueryRs';
    }
}
