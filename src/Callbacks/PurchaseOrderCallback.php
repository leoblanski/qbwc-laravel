<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class PurchaseOrderCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process purchase order data from the QuickBooks response.
    }
}
