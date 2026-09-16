<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Traits\HasTokenCacher;
use Abolaradev\Otp\Traits\HasTokenHasher;
use Abolaradev\Otp\Services\OtpDetails;
use Illuminate\Support\Facades\Cache;

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
     * Hash the OTP token.
     *
     * @return self
     */
    public function hash() :self
    {
        $this->hashToken();

        return $this;
    }
    
    /**
     * Store the hashed OTP token in the cache.
     *
     * @return void
     */
    public function cache() :void
    {
        $this->addTokenToCache();
    }

} 