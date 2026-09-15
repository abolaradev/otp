<?php

namespace Abolaradev\Otp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abolaradev\Otp\Otp
 */
class Otp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abolaradev\Otp\Otp::class;
    }
}
