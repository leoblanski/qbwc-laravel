<?php

namespace RegalWings\QbwcLaravel\Callbacks;

abstract class QbwcCallback
{
    /**
     * Handle the QuickBooks Web Connector response.
     *
     * @param \SimpleXMLElement $data Parsed XML data from the response.
     */
    abstract public function handleResponse($data, $file = null);
}
