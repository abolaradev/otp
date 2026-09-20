<?php 

namespace Abolaradev\Otp\Exceptions;


class OtpInvalidTokenException extends OtpException
{
    protected function getMessageKey(): string
    {
        return 'otp::exceptions.invalid_token';
    }
}