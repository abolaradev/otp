<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Facades\Otp;
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
            value: [
                'expire_at' => $this->otpDetails->getExpiration() + time(),
                'token' => $this->getHashedToken()
            ],
            ttl: $this->otpDetails->getExpiration()
        );
    }


    /**
     * Retrieve the cached hashed OTP token.
     */
    protected function getCachedToken(): string
    {
        $cache = Cache::get($this->getCachedTokenKey());

        return $cache['token'];
    }

    /**
     * Generate the cache key for the OTP token.
     */
    private function getCachedTokenKey(): string
    {
        return Otp::generateTokenKey(
            recipient:  $this->otpDetails->getRecipient(),
            purpose: $this->otpDetails->getPurpose()
        );
    }
}