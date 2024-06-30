<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class JournalEntryQuery extends QbmxlQuery
{
    protected function getQueryElement()
    {
        return 'JournalEntryQueryRq';
    }

    protected function getResponseElement()
    {
        return 'JournalEntryQueryRs';
    }
}
