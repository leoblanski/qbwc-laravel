<?php

namespace AaronGRTech\QbwcLaravel\Providers;

use AaronGRTech\QbwcLaravel\Http\Controllers\SoapController;
use AaronGRTech\QbwcLaravel\Queue\QbQueryQueue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use SoapServer;

class SoapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SoapServer::class, function ($app) {
            $options = [
                'uri' => config('qbwc.routes.prefix'),
                'classmap' => \AaronGRTech\QbwcLaravel\ClassMap::get(),
            ];
            $server = new SoapServer(config('qbwc.soap.wsdl'), $options);
            return $server;
        });

        $this->app->singleton(QbQueryQueue::class, function ($app) {
            return new QbQueryQueue();
        });
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
        Route::middleware([])
            ->prefix(config('qbwc.routes.prefix'))
            ->group(function () {
                Route::post('/', [SoapController::class, 'handle']);
            });
    }
}