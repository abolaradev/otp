<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Traits\HasActiveToken;
use Abolaradev\Otp\Traits\HasRateLimiter;
use Abolaradev\Otp\Traits\HasTokenDispatcher;
use Abolaradev\Otp\Traits\HasTokenGenerator;

class OtpIssuance
{
    use HasTokenGenerator, HasTokenDispatcher , HasActiveToken , HasRateLimiter;

    /**
     * Create a new OTP issuance instance using the configured token settings.
     */
    public function __construct()
    {
        $this->length =  config('otp.token_length');
        $this->expiration = config('otp.token_expiration');
        $this->purpose = config('otp.token_purpose');
        $this->channel = config('otp.default');
    }
} 