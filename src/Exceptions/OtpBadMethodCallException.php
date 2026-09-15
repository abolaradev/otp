<?php
 
namespace Abolaradev\Otp\Exceptions;

use Abolaradev\Otp\Otp;
use BadMethodCallException;

class OtpBadMethodCallException extends BadMethodCallException
{
    public function __construct(string $method)
    {
        $class = Otp::class;
        $message = sprintf(
            'Call to undefined method %s::%s()',
            $class,
            $method
        );

        parent::__construct($message);
    }
}