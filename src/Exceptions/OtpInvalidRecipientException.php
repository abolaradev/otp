<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpInvalidRecipientException extends Exception
{
    public function __construct()
    {
        parent::__construct('The given recipient is invalid.');
    }
} 