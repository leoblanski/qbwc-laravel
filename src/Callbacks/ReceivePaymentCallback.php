<?php

namespace App\Callbacks;

class ReceivePaymentCallback extends QbwcCallback
{
    public function handleResponse($data)
    {
        // Process receive payment data from the QuickBooks response.
    }
}
