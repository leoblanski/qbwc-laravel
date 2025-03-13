<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class ReceivePaymentCallback extends QbwcCallback
{
    public function handleResponse($data)
    {
        // Process receive payment data from the QuickBooks response.
    }
}
