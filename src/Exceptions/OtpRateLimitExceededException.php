<?php

namespace Abolaradev\Otp\Exceptions;


class OtpRateLimitExceededException extends OtpException
{
    protected function getMessageKey(): string
    {
        return "otp::exceptions.token_rate_limit";
    }
}