<?php

namespace Abolaradev\Otp\Exceptions;

class OtpInvalidRecipientException extends OtpException
{
    protected function getMessageKey(): string
    {
        return 'otp::exceptions.invalid_recipient';
    }
} 