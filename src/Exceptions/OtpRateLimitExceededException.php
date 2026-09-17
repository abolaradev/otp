<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpRateLimitExceededException extends Exception
{
    public function __construct()
    {
        parent::__construct('Too many OTP requests. Please try again later.');
    }
}