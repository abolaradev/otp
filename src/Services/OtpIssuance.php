<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Enums\OtpProcessType;
use Abolaradev\Otp\Events\TokenGenerated;
use Abolaradev\Otp\Traits\HasActiveToken;
use Abolaradev\Otp\Traits\HasOtpProperties;
use Abolaradev\Otp\Traits\HasRateLimiter;
use Illuminate\Support\Str;

class OtpIssuance
{
    use HasOtpProperties , HasActiveToken , HasRateLimiter;

    /**
     * Create a new OTP issuance instance using the configured token settings.
     */
    public function __construct()
    {
        $this->length =  config('otp.token_length');
        $this->expiration = config('otp.token_expiration');
        $this->purpose = config('otp.token_purpose');
        $this->channel = config('otp.default');
    }

    /**
     * Set the length of the OTP token.
     *
     * @param int $length
     * @return $this
     */
    public function length(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Set the expiration time of the OTP token.
     *
     * @param int $expiration
     * @return $this
     */
    public function expiration(int $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Set the purpose of the OTP token.
     *
     * @param string $purpose
     * @return $this
     */
    public function purpose(string $purpose): self
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Generate a cryptographically secure numeric OTP token.
     *
     * The generated token is padded with leading zeros to ensure
     * that its length always matches the configured length.
     *
     * @return string
     *
     * @throws \Random\RandomException
     */
    private function generateToken(): string
    {
        $max = pow(10, $this->length) - 1;

        $value = (string) random_int(0, $max);

        return Str::padLeft($value, $this->length, '0');
    }

     /**
     * Set the recipient of the OTP token.
     *
     * @param string $recipient
     * @return $this
     */
    public function to(string $recipient) :self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Set the channel of the OTP Delivery
     *
     * @param  string $channel
     * @return $this
     */
    public function channel(string $channel) :self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Dispatch the OTP issuance process.
     *
     * Applies the issuance rate limit, ensures that no active OTP exists
     * for the recipient, generates the OTP details, and dispatches the
     * token generated event.
     *
     * @return void
     *
     * @throws OtpRateLimitExceededException If the issuance rate limit has been exceeded.
     * @throws OtpActiveTokenExistsException If an active OTP already exists for the recipient.
     */
    public function dispatch() :void
    {
        $this->rateLimit(OtpProcessType::Issuance, function(){
            $this->ensureNoActiveToken(function(){
                $otpDetails = OtpDetails::fromArray([
                    'token' => $this->generateToken(),
                    'recipient' => $this->recipient,
                    'purpose' => $this->purpose,
                    'expiration' => $this->expiration,
                    'channel'=> $this->channel
                ]);
            
                event(new TokenGenerated($otpDetails));
            });
        });
    }
} 