<?php

namespace Abolaradev\Otp\Listeners;

use Abolaradev\Otp\Events\TokenReceived;
use Abolaradev\Otp\Services\OtpVerifier;

class VerifyToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TokenReceived $event): void
    {
        $otpDetails = $event->otpDetails;

        (new OtpVerifier($otpDetails))->verifyToken();
    }
}