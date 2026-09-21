<?php

use App\Channels\LogChannel;
use App\Channels\SmsIrChannel;

return [

    /*
    |--------------------------------------------------------------------------
    | Default OTP Channel
    |--------------------------------------------------------------------------
    |
    | The default channel used to deliver OTP tokens.
    |
    */

    'default' => env('OTP_DEFAULT_CHANNEL', 'log'),

    /*
    |--------------------------------------------------------------------------
    | OTP Token Length
    |--------------------------------------------------------------------------
    |
    | The number of digits generated for each OTP token.
    |
    */

    'token_length' => env('OTP_TOKEN_LENGTH', 6),

    /*
    |--------------------------------------------------------------------------
    | OTP Token Purpose
    |--------------------------------------------------------------------------
    |
    | The default purpose assigned to generated OTP tokens.
    | This value is also used when no purpose is explicitly provided.
    |
    */

    'token_purpose' => env('OTP_TOKEN_PURPOSE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | OTP Token Expiration
    |--------------------------------------------------------------------------
    |
    | The amount of time, in seconds, an OTP token remains valid.
    |
    */

    'token_expiration' => env('OTP_TOKEN_EXPIRATION', 120),

    /*
    |--------------------------------------------------------------------------
    | OTP Rate Limiter
    |--------------------------------------------------------------------------
    |
    | Configure the maximum number of OTP attempts allowed within
    | the configured decay period.
    |
    */

    'rate_limiter' => [
        'max_attempts' => env('OTP_RATE_LIMIT_MAX_ATTEMPTS', 5),
        'decay_seconds' => env('OTP_RATE_LIMIT_DECAY_SECONDS', 3600),
    ],

    /*
    |--------------------------------------------------------------------------
    | OTP Channels
    |--------------------------------------------------------------------------
    |
    | Register the available OTP delivery channels and their configuration.
    |
    */

    'channels' => [

        'log' => [
            'driver' => LogChannel::class,
        ],

        'smsir' => [
            'driver' => SmsIrChannel::class,
            'api_key' => env('SMSIR_API_KEY'),
            'template_id' => env('SMSIR_TEMPLATE_ID'),
        ],

    ],

];