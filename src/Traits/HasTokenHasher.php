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
    protected function hash(string $token): self
    {
        $this->hashedToken = Hash::make($token);

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
    protected function check(string $token): bool
    {
        return Hash::check($token, $this->getHashedToken());
    }
}