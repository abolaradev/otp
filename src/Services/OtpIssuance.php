<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Traits\HasActiveToken;
use Abolaradev\Otp\Traits\HasRateLimiter;
use Abolaradev\Otp\Traits\HasTokenDispatcher;
use Abolaradev\Otp\Traits\HasTokenGenerator;

class OtpIssuance
{
    use HasTokenGenerator, HasTokenDispatcher , HasActiveToken , HasRateLimiter;
} 