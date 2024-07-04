<?php

namespace AaronGRTech\QbwcLaravel\Providers;

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
            $packageBaseDir . '/wsdl/QBWebConnectorSvc.wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        ], 'qbwc-wsdl');

        $this->publishes([
            $packageBaseDir . '/config/qbwc.php' => config_path('qbwc.php'),
        ], 'qbwc-config');

        $this->publishes([
            __DIR__ . '/../Migrations/2023_07_01_000000_create_queues_table.php' => database_path('migrations/Qbwc/' . date('Y_m_d_His', time()) . '_create_queues_table.php'),
            __DIR__ . '/../Migrations/2023_07_01_000001_create_tasks_table.php' => database_path('migrations/Qbwc/' . date('Y_m_d_His', time()) . '_create_tasks_table.php'),
            __DIR__ . '/../Migrations/2023_07_01_000002_create_task_configs_table.php' => database_path('migrations/Qbwc/' . date('Y_m_d_His', time()) . '_create_task_configs_table.php'),
        ], 'qbwc-migrations');

        $this->registerRoutes();

        $this->publishes([
            $packageBaseDir . '/Callbacks/QbwcCallback.php' => app_path('Callbacks/QbwcCallback.php'),
            $packageBaseDir . '/Callbacks/InvoiceCallback.php' => app_path('Callbacks/InvoiceCallback.php'),
        ], 'qbwc-callbacks');

        $this->publishes([
            $packageBaseDir . '/Models/Qbwc/Queue.php' => app_path('Models/Qbwc/Queue.php'),
            $packageBaseDir . '/Models/Qbwc/Task.php' => app_path('Models/Qbwc/Task.php'),
            $packageBaseDir . '/Models/Qbwc/TaskConfig.php' => app_path('Models/Qbwc/TaskConfig.php'),
        ], 'qbwc-models');

        // Publish other resources like controllers if needed
        $this->publishes([
            $packageBaseDir . '/Http/Controllers/SoapController.php' => app_path('Http/Controllers/Qbwc/SoapController.php'),
        ], 'qbwc-controllers');
    }

    /**
     * Register the SOAP routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $prefix = config('qbwc.routes.prefix');
        $controller = config('qbwc.routes.controller');

        Route::middleware([])
            ->prefix($prefix)
            ->group(function () use ($controller) {
                Route::post('/', [$controller, 'handle']);
            });
    }
}