<?php

namespace Abolaradev\Otp\Traits;

use Illuminate\Support\Facades\Cache;

trait HasTokenCacher 
{
    /**
     * Add the hashed OTP token to the cache.
    */
    protected function addTokenToCache(): void
    {
        Cache::add(
            key: $this->getCachedTokenKey(),
            value: $this->getHashedToken(),
            ttl: $this->otpDetails->getExpiration()
        );
    }


    /**
     * Retrieve the cached hashed OTP token.
     */
    protected function getCachedToken(): string
    {
        return Cache::get($this->getCachedTokenKey());
    }

    /**
     * Generate the cache key for the OTP token.
     */
    private function getCachedTokenKey(): string
    {
        return sprintf(
            'otp:%s:%s',
            $this->otpDetails->getPurpose(),
            $this->otpDetails->getRecipient()
        );
    }
}