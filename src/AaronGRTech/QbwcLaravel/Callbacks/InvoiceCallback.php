<?php

namespace App\Callbacks;

class InvoiceCallback extends QbwcCallback
{
    public function handleResponse($data)
    {
        // Process invoice data from the QuickBooks response.
        $this->processInvoiceData($data);
    }

    protected function processInvoiceData($data)
    {
        //Example of how to extract invoice data from the response.
        $invoiceId = (string)$data->Invoice->ID;
        $amount = (float)$data->Invoice->Amount;

        $this->saveInvoice($invoiceId, $amount);
    }

    protected function saveInvoice($invoiceId, $amount)
    {
        //Do something with the invoice data.
    }
}
