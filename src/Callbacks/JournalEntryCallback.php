<?php

namespace App\Callbacks;

use RegalWings\QbwcLaravel\Callbacks\QbwcCallback;

class JournalEntryCallback extends QbwcCallback
{
    public function handleResponse($data, $file = null)
    {
        // Process journal entry data from the QuickBooks response.
    }
}
