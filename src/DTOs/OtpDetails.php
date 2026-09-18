<?php

namespace Abolaradev\Otp\DTOs;

/**
 * Data Transfer Object containing OTP token details.
 */
readonly class OtpDetails
{
    /**
     * Create a new OtpDetails instance.
     *
     * @param string $token The OTP token.
     * @param string $recipient The recipient of the OTP token.
     * @param string $purpose The purpose of the OTP token.
     * @param int|null $expiration The token expiration time, if applicable.
     * @param string|null $channel The OTP delivery channel, if applicable.
     */
    public function __construct(
        private string $token,
        private string $recipient,
        private string $purpose,
        private ?int $expiration =null,
        private ?string $channel = null,
    ) {}
    
   /**
     * Create an OTP details instance from an array.
     *
     * @param array $data The OTP details attributes.
     *
     * @return self A new OTP details instance.
     */
    public static function fromArray(array $data) :self
    {
        return new self(
            token: $data['token'],
            recipient: $data['recipient'],
            purpose: $data['purpose'],
            expiration: $data['expiration'] ?? null ,
            channel: $data['channel'] ?? null 
        );
    }
    
    /**
     * Get the OTP token.
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