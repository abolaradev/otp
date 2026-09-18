<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Exceptions\OtpActiveTokenExistsException;
use Abolaradev\Otp\Exceptions\OtpTokenExpiredException;
use Closure;
use Illuminate\Support\Facades\Cache;

trait HasActiveToken
{
    /**
     * Determine whether an active OTP token exists in the cache.
     *
     * @return bool
     */
    private function hasActiveToken(): bool
    {
        $key = sprintf(
            'otp:%s:%s',
            $this->purpose,
            $this->recipient
        );

        return Cache::has($key);
    }

    /**
     * Ensure that no active OTP token exists before executing the issuance process.
     *
     * @param Closure $callable The callback to execute when no active token exists.
     *
     * @return mixed
     *
     * @throws OtpActiveTokenExistsException If an active OTP token already exists.
     */
    protected function ensureNoActiveToken(Closure $callable): mixed
    {
        if ($this->hasActiveToken()) {
            throw new OtpActiveTokenExistsException;
        }

        return $callable();
    }

    /**
     * Ensure that an active OTP token exists before executing the verification process.
     *
     * @param Closure $callable The callback to execute when an active token exists.
     *
     * @return mixed
     *
     * @throws OtpTokenExpiredException If no active OTP token exists.
     */
    protected function ensureActiveToken(Closure $callable): mixed
    {
        if (!$this->hasActiveToken()) {
            throw new OtpTokenExpiredException;
        }

        return $callable();
    }
}