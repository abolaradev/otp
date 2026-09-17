<?php

namespace Abolaradev\Otp\Services;


/**
 * Data Transfer Object containing the details of a generated OTP token.
 */
readonly class OtpDetails
{
    /**
     * Create a new TokenDetails instance.
     *
     * @param string $token The generated OTP token.
     * @param int $expiration The token expiration time.
     * @param string $purpose The purpose of the OTP token.
     * @param string $channel The OTP Delivery Channel.
     * @param string $recipient The recipient of the OTP token.
     */
    public function __construct(
        private string $token,
        private int $expiration,
        private string $purpose,
        private string $channel,
        private string $recipient
    ) {}

    /**
     * Get the generated OTP token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get the token expiration time.
     *
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     * Get the purpose of the OTP token.
     *
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }
    
    /**
     * Get the OTP Delivery Channel
     *
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Get the recipient of the OTP token.
     *
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }
}