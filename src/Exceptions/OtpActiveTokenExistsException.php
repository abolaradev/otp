<?php

namespace Abolaradev\Otp\Exceptions;


class OtpActiveTokenExistsException extends OtpException
{
    protected function getMessageKey(): string
    {
        return 'otp::exceptions.active_token';
    }
}