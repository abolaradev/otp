<?php

namespace VendorName\Skeleton;

use Illuminate\Support\ServiceProvider;
use VendorName\Skeleton\Commands\SkeletonCommand;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;

class SkeletonServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/skeleton.php',
            'skeleton'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Register the package views as a Livewire namespace
        Livewire::addNamespace(
            namespace: 'skeleton',
            viewPath: __DIR__ . '/../resources/views/livewire',
        );

        // Register the package Blade components namespace
        Blade::componentNamespace(__DIR__ . '/../resources/views/components','skeleton');

        // Load the package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/skeleton.php');

        // Load the package views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'skeleton');

        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish the package configuration file
        $this->publishes([
            __DIR__.'/../config/skeleton.php' => config_path('skeleton.php'),
        ], ['skeleton', 'skeleton-config']);

        // Publish the package views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/skeleton'),
        ], ['skeleton', 'skeleton-views']);

        // Publish the package assets
        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/skeleton'),
        ], ['skeleton', 'skeleton-assets']);

        // Publish the package migrations
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['skeleton', 'skeleton-migrations']);

        // Register the package Artisan commands
        $this->commands([
            SkeletonCommand::class
        ]);
    }
}
