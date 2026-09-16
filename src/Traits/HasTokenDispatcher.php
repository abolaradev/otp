<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Events\TokenGenerated;

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
     * Dispatch the generated OTP token.
     *
     * Builds the token details for the configured recipient
     * and dispatches the TokenGenerated event.
     *
     * @return void
     */
    public function dispatch() :void
    {
        $otpDetails = $this->buildTokenDetails();
        event(new TokenGenerated($otpDetails));
    }
}