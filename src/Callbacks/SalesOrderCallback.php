<?php

namespace App\Callbacks;

use AaronGRTech\QbwcLaravel\Callbacks\QbwcCallback;

class SalesOrderCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process sales order data from the QuickBooks response.
    }
}
