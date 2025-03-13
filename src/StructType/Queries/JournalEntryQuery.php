<?php

namespace RegalWings\QbwcLaravel\StructType\Queries;

class JournalEntryQuery extends QbxmlQuery
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
