<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class BillCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process bill data from the QuickBooks response.
    }
}
