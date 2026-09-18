<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpTokenExpiredException extends Exception
{
    public function __construct()
    {
        parent::__construct('The OTP token has expired.');
    }
}
