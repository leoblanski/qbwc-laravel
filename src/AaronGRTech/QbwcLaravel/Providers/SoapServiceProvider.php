<?php

namespace AaronGRTech\QbwcLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SoapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/mypackage.php' => config_path('mypackage.php'),
        ], 'config');

        $this->registerRoutes();

        $this->publishes([
            __DIR__.'/../wsdl/QBWebConnectorSvc.wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        ]);
    }

    /**
     * Register the SOAP routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::middleware(config('qbwc-laravel.routes.middleware'))
            ->prefix(config('qbwc-laravel.routes.prefix'))
            ->group(function () {
                Route::post('/serverVersion', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@serverVersion');
                Route::post('/clientVersion', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@clientVersion');
                Route::post('/authenticate', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@authenticate');
                Route::post('/sendRequestXML', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@sendRequestXML');
                Route::post('/receiveResponseXML', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@receiveResponseXML');
            });
    }
}