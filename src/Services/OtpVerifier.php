<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Traits\HasTokenCacher;
use Abolaradev\Otp\Traits\HasTokenHasher;
use Illuminate\Support\Facades\Cache;

class OtpVerifier
{
    use HasTokenHasher , HasTokenCacher;

    /**
     * Create a new OTP verifier instance.
     *
     * @param  \OtpDetails $otpDetails
     * @return void
     */
    public function __construct(
        private OtpDetails $otpDetails
    ){}


   /**
     * Verify the provided OTP token against the cached token.
     *
     * Removes the cached token after successful verification to prevent
     * the OTP from being reused.
     *
     * @return void
     */
    public function verifyToken(): void
    {
        $cachedToken = $this->getCachedToken();
        $verify = $this->checkHashedToken(
            $this->otpDetails->getToken(),
            $cachedToken
        );

        if($verify){
            Cache::forget($this->getCachedTokenKey());
        }
    }
}