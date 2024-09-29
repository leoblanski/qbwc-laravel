<?php

namespace App\Callbacks;

use AaronGRTech\QbwcLaravel\Callbacks\QbwcCallback;

class SalesReceiptCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process sales receipt data from the QuickBooks response.
    }
}
