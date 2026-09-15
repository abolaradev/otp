<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Exceptions\OtpInvalidRecipientException;
use Illuminate\Support\Str;

/**
 * Provides common functionality for managing OTP recipients.
 *
 * This class validates and stores the recipient before delegating
 * the OTP flow to the appropriate issuance or verification context.
 */
abstract class OtpManager
{
    /**
     * The recipient associated with the current OTP operation.
     */
    private string $recipient = '';

    /**
     * Set and validate the OTP recipient.
     *
     * @param string $recipient The recipient mobile number.
     *
     * @throws OtpInvalidRecipientException
     */
    protected function setRecipient(string $recipient): void
    {
        if (!Str::isMatch('/^09[0-9]{9}$/', $recipient)) {
            throw new OtpInvalidRecipientException;
        }

        $this->recipient = $recipient;
    }

    /**
     * Get the current OTP recipient.
     *
     * @return string
     */
    protected function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * Create the OTP issuance context.
     *
     * @return OtpIssuance
     */
    abstract protected function issuance(): OtpIssuance;

    /**
     * Create the OTP verification context.
     *
     * @return OtpVerfication
     */
    abstract protected function verification(): OtpVerfication;
}