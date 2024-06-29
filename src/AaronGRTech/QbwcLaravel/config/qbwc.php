<?php

return [
    'admin' => [
        'user' => env('QBWC_USER', 'Admin'),
        'password' => env('QBWC_PASSWORD')
    ],
    'soap' => [
        'wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        'version' => env('QBWC_VERSION', '1.0'),
    ],
    'routes' => [
        'prefix' => env('QBWC_ROUTE_PREFIX', 'soap'),
        'middleware' => 'api'
    ]
];