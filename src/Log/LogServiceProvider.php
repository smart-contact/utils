<?php

namespace SmartContact\Log;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use SmartContact\Log\middleware\ScApiHttpRequest;
use SmartContact\Log\middleware\ScWebHttpRequest;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $router = $this->app->make(Router::class);
        $this->app->singleton(ScApiHttpRequest::class);
        $router->pushMiddlewareToGroup('api', ScApiHttpRequest::class);
        $router->pushMiddlewareToGroup('web', ScWebHttpRequest::class);

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->singleton('sclog', function ($app) {
            return new Log();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sclog'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {

    }
}
