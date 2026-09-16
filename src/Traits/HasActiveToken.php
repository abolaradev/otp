<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Exceptions\OtpActiveTokenExistsException;
use Closure;
use Illuminate\Support\Facades\Cache;

trait HasActiveToken
{
    /**
     * Ensure that no active OTP token exists before executing the callback.
     *
     * @throws OtpActiveTokenExistsException
     */
    protected function ensureNoActiveToken(Closure $callable) :mixed
    {
        $key = sprintf(
            'otp:%s:%s',
            $this->purpose,
            $this->recipient
        );

        if(Cache::has($key)){
            throw new OtpActiveTokenExistsException;
        }

        return $callable();
    }
}