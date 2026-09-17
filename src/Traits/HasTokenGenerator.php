<?php

namespace Abolaradev\Otp\Traits;

use Abolaradev\Otp\Services\OtpDetails;
use Illuminate\Support\Str;

trait HasTokenGenerator
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
    protected function generateToken(): string
    {
        $max = pow(10, $this->length) - 1;

        $value = (string) random_int(0, $max);

        return Str::padLeft($value, $this->length, '0');
    }
}