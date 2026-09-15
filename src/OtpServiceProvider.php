<?php

namespace Abolaradev\Otp;

use Illuminate\Support\ServiceProvider;

class OtpServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/otp.php',
            'otp'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish the package configuration file
        $this->publishes([
            __DIR__.'/../config/otp.php' => config_path('otp.php'),
        ], ['otp', 'otp-config']);

        // Publish the package migrations
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['otp', 'otp-migrations']);

    }
}
