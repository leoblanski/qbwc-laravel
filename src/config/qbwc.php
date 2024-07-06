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
        'middleware' => []
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
        'AccountQueryRs' => \App\Callbacks\AccountCallback::class,
        'BillQueryRs' => \App\Callbacks\BillCallback::class,
        'CreditMemoQueryRs' => \App\Callbacks\CreditMemoCallback::class,
        'CustomerQueryRs' => \App\Callbacks\CustomerCallback::class,
        'EmployeeQueryRs' => \App\Callbacks\EmployeeCallback::class,
        'EstimateQueryRs' => \App\Callbacks\EstimateCallback::class,
        'InvoiceQueryRs' => \App\Callbacks\InvoiceCallback::class,
        'ItemQueryRs' => \App\Callbacks\ItemCallback::class,
        'JournalEntryQueryRs' => \App\Callbacks\JournalEntryCallback::class,
        'PurchaseOrderQueryRs' => \App\Callbacks\PurchaseOrderCallback::class,
        'ReceivePaymentQueryRs' => \App\Callbacks\ReceivePaymentCallback::class,
        'SalesOrderQueryRs' => \App\Callbacks\SalesOrderCallback::class,
        'SalesReceiptQueryRs' => \App\Callbacks\SalesReceiptCallback::class,
        'VendorQueryRs' => \App\Callbacks\VendorCallback::class,
    ],
];