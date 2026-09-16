<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Services\OtpDetails;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

trait HasTokenCacher 
{
    protected function add(OtpDetails $otpDetails , string $hashedToken) 
    {
        $c=Cache::add(
            key: "otp:".$otpDetails->getPurpose().":".$otpDetails->getRecipient(),
            value: $hashedToken,
            ttl: $otpDetails->getExpiration()
        );

        dump($c);
    }

    protected function has()
    {

    }
}