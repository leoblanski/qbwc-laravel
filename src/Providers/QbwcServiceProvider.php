<?php

namespace RegalWings\QbwcLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class QbwcServiceProvider extends ServiceProvider
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

        // $this->loadMigrationsFrom($packageBaseDir . '/src/Migrations');

        $this->publishes([
            $packageBaseDir . '/src/Migrations/create_queues_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbwc_queue_table.php'),
            $packageBaseDir . '/src/Migrations/create_task_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbwc_tasks_table.php'),
            $packageBaseDir . '/src/Migrations/create_task_configs_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbwc_task_configs_table.php'),
        ], 'qbwc-migrations');

        $this->registerRoutes();

        $this->publishes([
            $packageBaseDir . '/src/Callbacks/AccountCallback.php' => app_path('Quickbooks/Callbacks/AccountCallback.php'),
            $packageBaseDir . '/src/Callbacks/BillCallback.php' => app_path('Quickbooks/Callbacks/BillCallback.php'),
            $packageBaseDir . '/src/Callbacks/CreditMemoCallback.php' => app_path('Quickbooks/Callbacks/CreditMemoCallback.php'),
            $packageBaseDir . '/src/Callbacks/CustomerCallback.php' => app_path('Quickbooks/Callbacks/CustomerCallback.php'),
            $packageBaseDir . '/src/Callbacks/EmployeeCallback.php' => app_path('Quickbooks/Callbacks/EmployeeCallback.php'),
            $packageBaseDir . '/src/Callbacks/EstimateCallback.php' => app_path('Quickbooks/Callbacks/EstimateCallback.php'),
            $packageBaseDir . '/src/Callbacks/InvoiceCallback.php' => app_path('Quickbooks/Callbacks/InvoiceCallback.php'),
            $packageBaseDir . '/src/Callbacks/ItemCallback.php' => app_path('Quickbooks/Callbacks/ItemCallback.php'),
            $packageBaseDir . '/src/Callbacks/JournalEntryCallback.php' => app_path('Quickbooks/Callbacks/JournalEntryCallback.php'),
            $packageBaseDir . '/src/Callbacks/PurchaseOrderCallback.php' => app_path('Quickbooks/Callbacks/PurchaseOrderCallback.php'),
            $packageBaseDir . '/src/Callbacks/ReceivePaymentCallback.php' => app_path('Quickbooks/Callbacks/ReceivePaymentCallback.php'),
            $packageBaseDir . '/src/Callbacks/SalesOrderCallback.php' => app_path('Quickbooks/Callbacks/SalesOrderCallback.php'),
            $packageBaseDir . '/src/Callbacks/SalesReceiptCallback.php' => app_path('Quickbooks/Callbacks/SalesReceiptCallback.php'),
            $packageBaseDir . '/src/Callbacks/VendorCallback.php' => app_path('Quickbooks/Callbacks/VendorCallback.php'),
        ], 'qbwc-callbacks');

        $this->publishes([
            $packageBaseDir . '/src/Models/Queue.php' => app_path('Models/Qbwc/Queue.php'),
            $packageBaseDir . '/src/Models/Task.php' => app_path('Models/Qbwc/Task.php'),
            $packageBaseDir . '/src/Models/TaskConfig.php' => app_path('Models/Qbwc/TaskConfig.php'),
        ], 'qbwc-models');

        // Publish other resources like controllers if needed
        $this->publishes([
            $packageBaseDir . '/src/Http/Controllers/SoapController.php' => app_path('Http/Controllers/SoapController.php'),
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
                Route::post('/{queueName?}/{file?}', [$controller, 'handle']);
            });
    }
}
