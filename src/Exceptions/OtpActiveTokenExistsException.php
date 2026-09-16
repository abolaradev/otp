<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpActiveTokenExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('An active OTP token already exists for this recipient. ');
    }
}