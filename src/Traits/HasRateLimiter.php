<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Enums\OtpProcessType;
use Abolaradev\Otp\Exceptions\OtpRateLimitExceededException;
use Closure;
use Illuminate\Support\Facades\RateLimiter;

trait HasRateLimiter
{
    /**
     * Execute the given callback while enforcing the OTP rate limit.
     *
     * The attempt is recorded before executing the callback to ensure
     * that it is counted even when the callback throws an exception.
     *
     * @param  OtpProcessType  $process
     * @param  Closure         $callback
     *
     * @throws OtpRateLimitExceededException
     */
    protected function rateLimit(OtpProcessType $process, Closure $callback) :void
    {
        $processValue = $process->value;
        $maxAttempts = config('otp.rate_limiter.max_attempts');
        $decaySeconds = config('otp.rate_limiter.decay_seconds'); 
        $key = "otp:rate-limiter:". md5($processValue.$this->recipient);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            throw new OtpRateLimitExceededException;
        }

        RateLimiter::hit($key, $decaySeconds);

        $callback();
    }
}