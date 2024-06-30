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
];