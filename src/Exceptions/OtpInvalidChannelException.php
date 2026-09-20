<?php

namespace Abolaradev\Otp\Exceptions;


class OtpInvalidChannelException extends OtpException
{
    public function __construct(string $channel)
    {
        $this->replace['channel'] = $channel;
        parent::__construct(__(
            $this->getMessageKey() , $this->replace
        ));
    }

    protected function getMessageKey(): string
    {
        return 'otp::exceptions.invalid_channel';
    }
}