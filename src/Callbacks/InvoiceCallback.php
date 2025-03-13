<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class InvoiceCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process invoice data from the QuickBooks response.
    }
}
