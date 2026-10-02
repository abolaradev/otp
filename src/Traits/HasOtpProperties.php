<?php

namespace Abolaradev\Otp\Traits;

trait HasOtpProperties
{
    /**
     * The length of the OTP token.
     */
    private int $length;

    /**
     * The expiration time of the OTP token.
     */
    private int $expiration;

    /**
     * The purpose of the OTP token.
     */
    private string $purpose;

    /**
    * The recipient of the OTP token.
    */
    private string $recipient; 

    /**
    * The OTP Delivery Channel.
    */
    private string $channel;

    /**
     * The OTP token received from the user for verification.
     */
    private string $token;
}