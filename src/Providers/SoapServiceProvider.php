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
        $packageBaseDir = dirname(__DIR__, 2);

        $this->publishes([
            $packageBaseDir . '/src/wsdl/QBWebConnectorSvc.wsdl' => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
        ], 'qbwc-wsdl');

        $this->publishes([
            $packageBaseDir . '/src/config/qbwc.php' => config_path('qbwc.php'),
        ], 'qbwc-config');

        $this->loadMigrationsFrom($packageBaseDir . '/src/Migrations');

        $this->publishes([
            $packageBaseDir . '/src/Migrations/create_queues_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_queues_table.php'),
            $packageBaseDir . '/src/Migrations/create_tasks_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_tasks_table.php'),
            $packageBaseDir . '/src/Migrations/create_task_configs_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_task_configs_table.php'),
        ], 'qbwc-migrations');

        $this->registerRoutes();

        $this->publishes([
            $packageBaseDir . '/src/Callbacks/QbwcCallback.php' => app_path('Callbacks/QbwcCallback.php'),
            $packageBaseDir . '/src/Callbacks/InvoiceCallback.php' => app_path('Callbacks/InvoiceCallback.php'),
        ], 'qbwc-callbacks');

        $this->publishes([
            $packageBaseDir . '/src/Models/Qbwc/Queue.php' => app_path('Models/Qbwc/Queue.php'),
            $packageBaseDir . '/src/Models/Qbwc/Task.php' => app_path('Models/Qbwc/Task.php'),
            $packageBaseDir . '/src/Models/Qbwc/TaskConfig.php' => app_path('Models/Qbwc/TaskConfig.php'),
        ], 'qbwc-models');

        // Publish other resources like controllers if needed
        $this->publishes([
            $packageBaseDir . '/src/Http/Controllers/SoapController.php' => app_path('Http/Controllers/Qbwc/SoapController.php'),
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

        Route::middleware(config('qbwc.routes.middleware'))
            ->prefix($prefix)
            ->group(function () use ($controller) {
                Route::post('/{queueName?}', [$controller, 'handle']);
            });
    }
}