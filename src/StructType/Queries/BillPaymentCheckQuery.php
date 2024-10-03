<?php

namespace AaronGRTech\QbwcLaravel\StructType\Queries;

class BillPaymentCheckQuery extends QbxmlQuery
{
    protected function getQueryElement()
    {
        return 'BillPaymentCheckQueryRq';
    }

    protected function getResponseElement()
    {
        return 'BillPaymentCheckQueryRs';
    }
}
