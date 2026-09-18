<?php

namespace Abolaradev\Otp\Traits;

use Illuminate\Support\Facades\Hash;

trait HasTokenHasher
{
    /**
     * The hashed OTP token.
     */
    private string $hashedToken;

    /**
     * Hash the given token.
     */
    protected function hashToken(): self
    {
        $this->hashedToken = Hash::make(
            $this->otpDetails->getToken()
        );

        return $this;
    }

    /**
     * Retrieve the hashed token.
     */
    protected function getHashedToken(): string
    {
        return $this->hashedToken;
    }

    /**
     * Determine whether the given token matches the hashed token.
     */
    protected function checkHashedToken(string $token , string $hashedToken): bool
    {
        return Hash::check($token, $hashedToken);
    }
}