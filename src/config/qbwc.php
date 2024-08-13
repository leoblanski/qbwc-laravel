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
    'model_map' => [
        'Account' => \App\Models\Account::class,
        'Bill' => \App\Models\Bill::class,
        'Credit' => \App\Models\Credit::class,
        'Customer' => \App\Models\Customer::class,
        'Employee' => \App\Models\Employee::class,
        'Estimate' => \App\Models\Estimate::class,
        'Invoice' => \App\Models\Invoice::class,
        'Item' => \App\Models\Item::class,
        'JournalEntry' => \App\Models\JournalEntry::class,
        'PurchaseOrder' => \App\Models\PurchaseOrder::class,
        'ReceivePayment' => \App\Models\ReceivePayment::class,
        'SalesOrder' => \App\Models\SalesOrder::class,
        'SalesReceipt' => \App\Models\SalesReceipt::class,
        'Vendor' => \App\Models\Vendor::class,
    ],
];