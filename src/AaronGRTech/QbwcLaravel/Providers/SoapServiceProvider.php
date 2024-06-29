<?php

namespace AaronGRTech\QbwcLaravel\Providers;

use AaronGRTech\QbwcLaravel\Http\Controllers\SoapDispatcherController;
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
        $packageBaseDir = dirname(__DIR__, 2);

        $this->publishes([
            $packageBaseDir . '/QbwcLaravel/config/qbwc.php' => config_path('qbwc.php'),
        ], 'config');

        $this->registerRoutes();

        $this->publishes([
            $packageBaseDir . '/QbwcLaravel/wsdl/QBWebConnectorSvc.wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        ], 'wsdl');
    }

    /**
     * Register the SOAP routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::middleware(config('qbwc.routes.middleware'))
            ->prefix(config('qbwc.routes.prefix'))
            ->group(function () {
                Route::post('/soap', [SoapDispatcherController::class, 'handle']);
            });
    }
}