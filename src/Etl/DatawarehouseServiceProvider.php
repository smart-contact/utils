<?php

namespace SmartContact\Etl;

use App\Console\Commands\WriteToDatawarehouse;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use SmartContact\Etl\exceptions\DatawarehouseServiceNotFound;
use SmartContact\Etl\modules\datawarehouse\DatawarehouseInterface;
use SmartContact\Etl\modules\datawarehouse\google\BigQuery;

class DatawarehouseServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }


        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->job(new \SmartContact\Etl\jobs\WriteToDatawarehouse())->everyMinute();
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(DatawarehouseInterface::class, function() {
            $datawarehouse = Config::get('sc_datawarehouse.datawarehouse');
            switch($datawarehouse) {
                case 'google': {
                    return new BigQuery();
                }
                default: throw new DatawarehouseServiceNotFound();
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['datawarehouse'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
// Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/config/datawarehouse.php' => config_path('sc_datawarehouse.php'),
        ], 'responses.config');
    }
}
