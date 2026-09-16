<?php

namespace Abolaradev\Otp\Services;


abstract class OtpManager
{
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