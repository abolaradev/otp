<?php

namespace Abolaradev\Otp\Services;

use Abolaradev\Otp\Traits\HasTokenCacher;
use Abolaradev\Otp\Traits\HasTokenHasher;
use Abolaradev\Otp\Services\OtpDetails;
use Illuminate\Support\Facades\Cache;

class OtpStorage
{
    use HasTokenCacher , HasTokenHasher{
        hash as hashToken;
    }
    
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
        $this->hashToken($this->otpDetails->getToken());

        return $this;
    }
    
    /**
     * Store the hashed OTP token in the cache.
     *
     * @return void
     */
    public function cache() :void
    {
        $this->add($this->otpDetails,$this->getHashedToken());
    }

} 