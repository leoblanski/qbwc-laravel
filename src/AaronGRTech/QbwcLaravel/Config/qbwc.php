<?php

return [
    'admin' => [
        'user' => env('QBWC_USER', 'Admin'),
        'password' => env('QBWC_PASSWORD')
    ],
    'soap' => [
        'wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl')
    ],
    'routes' => [
        'prefix' => env('QBWC_ROUTE_PREFIX', 'soap'),
        'middleware' => 'api'
    ]
];