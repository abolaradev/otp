<?php

namespace Abolaradev\Otp;

use Abolaradev\Otp\Commands\MakeOtpChannelCommand;
use Abolaradev\Otp\Events\TokenGenerated;
use Abolaradev\Otp\Events\TokenReceived;
use Abolaradev\Otp\Listeners\SendTokenToRecipient;
use Abolaradev\Otp\Listeners\VerifyToken;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
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
        // Register listeners for OTP token generation and verification events.
        Event::listen(TokenGenerated::class, SendTokenToRecipient::class);
        Event::listen(TokenReceived::class, VerifyToken::class);

        // Register the OTP Blade component namespace.
        Blade::componentNamespace(
            'otp',
            __DIR__ . '/../resources/views/components'
        );

        // Load the package translation files.
        $this->loadTranslationsFrom(
            __DIR__ . '/../lang',
            'otp'
        );

        // Load the package views
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'otp'
        );

        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish the package configuration file
        $this->publishes([
            __DIR__.'/../config/otp.php' => config_path('otp.php'),
        ], ['otp', 'otp-config']);

        // Publish the package assets
        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/otp'),
        ], ['otp', 'otp-assets']);

        // Publish the package language files
        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/otp'),
        ], ['otp', 'otp-lang']);

        // Publish the OTP channels
        $this->publishes([
            __DIR__.'/../channels' => app_path('Channels'),
            ['otp' , 'otp-channels']
        ]);

        // Publish the package commands
        $this->commands([
            MakeOtpChannelCommand::class,
        ]);
    }
}
