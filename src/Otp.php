<?php

namespace Abolaradev\Otp;

use Abolaradev\Otp\Exceptions\OtpBadMethodCallException;
use Abolaradev\Otp\Services\OtpIssuance;
use Abolaradev\Otp\Services\OtpManager;
use Abolaradev\Otp\Services\OtpVerfication;

/**
 * Provides the main entry point for interacting with the OTP system.
 *
 * The class routes fluent method calls to the appropriate OTP context:
 * token issuance or token verification.
 */
class Otp extends OtpManager
{
    /**
     * Create a new OTP issuance context.
     *
     * @return OtpIssuance
     */
    protected function issuance(): OtpIssuance
    {
        return (new OtpIssuance)->to($this->getRecipient());
    }

    /**
     * Create a new OTP verification context.
     *
     * @return OtpVerfication
     */
    protected function verification(): OtpVerfication
    {
        return (new OtpVerfication)->from($this->getRecipient());
    }

    /**
     * Handle calls to undefined methods.
     *
     * Routes the `to` and `from` methods to their corresponding
     * OTP contexts and throws an exception for unsupported methods.
     *
     * @param string $name The name of the called method.
     * @param array $arguments The arguments passed to the method.
     *
     * @return OtpIssuance|OtpVerfication
     *
     * @throws OtpBadMethodCallException
     */
    public function __call($name, $arguments)
    {
        if (!in_array($name, ['to', 'from'])) {
            throw new OtpBadMethodCallException(method: $name);
        }

        $this->setRecipient($arguments[0]);

        return match ($name) {
            'to' => $this->issuance(),
            'from' => $this->verification(),
        };
    }
}