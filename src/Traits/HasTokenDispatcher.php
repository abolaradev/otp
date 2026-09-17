<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Events\TokenGenerated;
use Abolaradev\Otp\Services\OtpDetails;

trait HasTokenDispatcher
{
    /**
    * The recipient of the OTP token.
    */
    private string $recipient; 

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
        $this->rateLimit('issuance', function(){
            $this->ensureNoActiveToken(function(){
                $otpDetails = new OtpDetails(
                    token: $this->generateToken(),
                    expiration: $this->expiration,
                    purpose: $this->purpose,
                    recipient: $this->recipient
                );

                event(new TokenGenerated($otpDetails));
            });
        });
    }
}