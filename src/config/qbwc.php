<?php

return [
    'user' => env('QBWC_USER', 'Admin'),
    'password' => env('QBWC_PASSWORD'),
    'soap' => [
        'ticket_prefix' => env('QBWC_TICKET_PREFIX', 'qbwc_'),
        'wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        'version' => env('QBWC_VERSION', '1.0'),
    ],
    'routes' => [
        'controller' => AaronGRTech\QbwcLaravel\Http\Controllers\SoapController::class,
        'prefix' => env('QBWC_ROUTE_PREFIX', 'soap'),
        'middleware' => 'api'
    ],
    'queue' => [
        'max_returned' => env('QBWC_MAX_RETURNED', 100),
        'queries' => [
            [
                'class' => \AaronGRTech\QbwcLaravel\StructType\Queries\InvoiceQuery::class,
                'params' => ['MaxReturned' => 1]
            ],
            // Add more queries as needed
        ],
    ],
    'callback_map' => [
        'AccountQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\AccountCallback::class,
        'BillQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\BillCallback::class,
        'CreditMemoQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\CreditMemoCallback::class,
        'CustomerQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\CustomerCallback::class,
        'EmployeeQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\EmployeeCallback::class,
        'EstimateQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\EstimateCallback::class,
        'InvoiceQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\InvoiceCallback::class,
        'ItemQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\ItemCallback::class,
        'JournalEntryQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\JournalEntryCallback::class,
        'PurchaseOrderQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\PurchaseOrderCallback::class,
        'ReceivePaymentQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\ReceivePaymentCallback::class,
        'SalesOrderQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\SalesOrderCallback::class,
        'SalesReceiptQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\SalesReceiptCallback::class,
        'VendorQueryRs' => \AaronGRTech\QbwcLaravel\Callbacks\VendorCallback::class,
    ],
];