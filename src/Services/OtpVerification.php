<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Traits\HasActiveToken;
use Abolaradev\Otp\Traits\HasRateLimiter;
use Abolaradev\Otp\Traits\HasTokenReceiver;

class OtpVerification
{
    use HasTokenReceiver , HasActiveToken , HasRateLimiter;
} 