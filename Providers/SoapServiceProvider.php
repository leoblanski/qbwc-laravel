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
        Route::middleware('api')
            ->prefix('soap')
            ->group(function () {
                Route::post('/serverVersion', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@serverVersion');
                Route::post('/clientVersion', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@clientVersion');
                Route::post('/authenticate', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@authenticate');
                Route::post('/sendRequestXML', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@sendRequestXML');
                Route::post('/receiveResponseXML', 'AaronGRTech\QbwcLaravel\Http\Controllers\SoapController@receiveResponseXML');
            });
    }
}