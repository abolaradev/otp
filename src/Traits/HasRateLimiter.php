<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Exceptions\OtpRateLimitExceededException;
use Closure;
use Illuminate\Support\Facades\RateLimiter;

trait HasRateLimiter
{
    /**
     * Execute the callback if the rate limit has not been exceeded.
     *
     * @param string $process The OTP process being rate-limited.
     * @param Closure $callback The callback to execute when the request is allowed.
     *
     * @return void
     * 
     * @throws OtpRateLimitExceededException If the rate limit has been exceeded.
     */
    protected function rateLimit(string $process, Closure $callback) :void
    {
        $maxAttempts = config('otp.rate_limiter.max_attempts');
        $decaySeconds = config('otp.rate_limiter.decay_seconds'); 
        $key = "otp:rate-limiter:". md5($process.$this->recipient);

        $execute = RateLimiter::attempt(
            key: $key,
            maxAttempts: $maxAttempts,
            callback: fn() => $callback(),
            decaySeconds: $decaySeconds
        );

        if(!$execute){
            throw new OtpRateLimitExceededException;
        }
    }
}