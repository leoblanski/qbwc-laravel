<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class CustomerCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process customer data from the QuickBooks response.
    }
}
