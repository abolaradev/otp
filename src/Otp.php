<?php

namespace Abolaradev\Otp;

use Abolaradev\Otp\Exceptions\OtpBadMethodCallException;
use Abolaradev\Otp\Exceptions\OtpInvalidRecipientException;
use Abolaradev\Otp\Services\OtpIssuance;
use Abolaradev\Otp\Services\OtpManager;
use Abolaradev\Otp\Services\OtpVerfication;
use Abolaradev\Otp\Services\OtpVerification;
use Illuminate\Support\Str;

/**
 * Provides the main entry point for interacting with the OTP system.
 *
 * The class routes fluent method calls to the appropriate OTP context:
 * token issuance or token verification.
 */
class Otp extends OtpManager
{
    /**
     * Create a new instance with the given recipient.
     *
     * @param string $recipient The recipient associated with the OTP.
     */
    public function __construct(private string $recipient = '')
    {}

    /**
     * Create a new OTP issuance context.
     *
     * @return OtpIssuance
     */
    protected function issuance(): OtpIssuance
    {
        return (new OtpIssuance)->to($this->recipient);
    }

    /**
     * Create a new OTP verification context.
     *
     * @return OtpVerfication
     */
    protected function verification(): OtpVerification
    {
        return (new OtpVerification)->from($this->recipient);
    }

   /**
    * Handle dynamic calls to the OTP issuance and verification methods.
    *
    * Validates the recipient and routes the call to the appropriate OTP context.
    *
    * @param string $name The called method name.
    * @param array $arguments The arguments passed to the method.
    *
    * @return OtpIssuance|OtpVerfication
    *
    * @throws OtpBadMethodCallException If the called method is not supported.
    * @throws OtpInvalidRecipientException If the recipient is invalid.
    */
    public function __call($name, $arguments)
    {
        if (!in_array($name, ['to', 'from'])) {
            throw new OtpBadMethodCallException(method: $name);
        }

        if (!Str::isMatch('/^09[0-9]{9}$/', $arguments[0])) {
            throw new OtpInvalidRecipientException;
        }

        $this->recipient = $arguments[0];

        return match ($name) {
            'to' => $this->issuance(),
            'from' => $this->verification(),
        };
    }
}