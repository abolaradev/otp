<?php

namespace Abolaradev\Otp\Exceptions;


class OtpTokenExpiredException extends OtpException
{
    protected function getMessageKey(): string
    {
        return 'otp::exceptions.token_expired';
    }
}
