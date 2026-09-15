<?php

namespace Abolaradev\Otp\DTO;


/**
 * Data Transfer Object containing the details of a generated OTP token.
 */
class TokenDetails
{
    /**
     * Create a new TokenDetails instance.
     *
     * @param string $token The generated OTP token.
     * @param int $expiration The token expiration time.
     * @param string $purpose The purpose of the OTP token.
     * @param string $recipient The recipient of the OTP token.
     */
    public function __construct(
        private string $token,
        private int $expiration,
        private string $purpose,
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
     * Get the recipient of the OTP token.
     *
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }
}