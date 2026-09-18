<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Traits\HasTokenCacher;
use Abolaradev\Otp\Traits\HasTokenHasher;

class OtpStorage
{
    use HasTokenHasher, HasTokenCacher;
    
    /**
     * Create a new OTP storage instance.
     *
     * @param  \OtpDetails $otpDetails
     * @return void
     */
    public function __construct(
        private OtpDetails $otpDetails
    ){}
    
    /**
     * Hash the OTP token and store the hashed value in the cache
     *
     * @return void
     */
    public function storeToken() :void
    {
        $this->hashToken();
        $this->addTokenToCache();
    }
} 