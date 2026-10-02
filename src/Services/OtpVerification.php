<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Enums\OtpProcessType;
use Abolaradev\Otp\Events\TokenReceived;
use Abolaradev\Otp\Traits\HasActiveToken;
use Abolaradev\Otp\Traits\HasOtpProperties;
use Abolaradev\Otp\Traits\HasRateLimiter;

class OtpVerification
{
    use HasOtpProperties, HasActiveToken , HasRateLimiter;

    /**
     * Set the recipient of the OTP token.
     *
     * @param string $recipient The recipient of the OTP token.
     *
     * @return $this
     */
    public function from(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Set the purpose of the OTP token.
     *
     * @param string $purpose The purpose of the OTP token.
     *
     * @return $this
     */
    public function purpose(string $purpose): self
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Set and validate the OTP token received from the user.
     *
     * @param string $token The OTP token provided for verification.
     *
     * @return $this
     */
    public function token(string $token): self
    {
        $this->token = $token;

        return $this;
    }

   /**
     * Verify the OTP token received from the user.
     *
     * Applies the verification rate limit, ensures that an active OTP token
     * exists, and dispatches the token received event for verification.
     *
     * @return void
     *
     * @throws OtpRateLimitExceededException If the verification rate limit has been exceeded.
     * @throws OtpTokenExpiredException If the OTP token has expired or is no longer active.
     */
    public function verify(): void
    {
        $this->ratelimit(OtpProcessType::Verification, function () {
            $this->ensureActiveToken(function () {
                $otpDetails = OtpDetails::fromArray([
                    'token' => $this->token,
                    'purpose' => $this->purpose,
                    'recipient' => $this->recipient,
                ]);

                event(new TokenReceived($otpDetails));
            });
        });
    }
} 