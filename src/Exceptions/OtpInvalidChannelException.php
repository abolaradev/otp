<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

class OtpInvalidChannelException extends Exception
{
    public function __construct(string $channel)
    {
        parent::__construct("The given channel $channel is not a valid OTP channel.");
    }
}