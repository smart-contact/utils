<?php

namespace SmartContact\Responses;

use Illuminate\Support\ServiceProvider;

class ResponsesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'smart-contact');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'smart-contact');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
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
        $this->mergeConfigFrom(__DIR__ . '/config/responses.php', 'responses');

        // Register the service the package provides.
        $this->app->singleton('responses', function ($app) {
            return new Responses;
        });

        $this->app->register(ResponseMacroServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['responses'];
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
            __DIR__ . '/config/responses.php' => config_path('log.php'),
        ], 'responses.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/smart-contact'),
        ], 'responses.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/smart-contact'),
        ], 'responses.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/smart-contact'),
        ], 'responses.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
