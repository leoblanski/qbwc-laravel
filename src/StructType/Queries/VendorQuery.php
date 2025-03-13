<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class VendorQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'VendorQueryRq';
    }

    protected function getResponseElement()
    {
        return 'VendorQueryRs';
    }
}
