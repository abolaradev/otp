<?php 

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpInvalidTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct('The given token is invalid.');
    }
}