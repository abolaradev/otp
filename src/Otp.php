<?php

namespace Abolaradev\Otp;

use Abolaradev\Otp\Exceptions\OtpBadMethodCallException;
use Abolaradev\Otp\Services\OtpIssuance;
use Abolaradev\Otp\Services\OtpManager;
use Abolaradev\Otp\Services\OtpVerfication;
use Abolaradev\Otp\Services\OtpVerification;
use Illuminate\Support\Facades\Cache;

/**
 * Provides the main entry point for interacting with the OTP system.
 *
 * The class routes fluent method calls to the appropriate OTP context:
 * token issuance or token verification.
 */
class Otp extends OtpManager
{
    /**
     * Create a new instance with the given recipient.
     *
     * @param string $recipient The recipient associated with the OTP.
     */
    public function __construct(private string $recipient = '')
    {}

    /**
     * Create a new OTP issuance context.
     *
     * @return OtpIssuance
     */
    protected function issuance(): OtpIssuance
    {
        return (new OtpIssuance)->to($this->recipient);
    }

    /**
     * Create a new OTP verification context.
     *
     * @return OtpVerfication
     */
    protected function verification(): OtpVerification
    {
        return (new OtpVerification)->from($this->recipient);
    }

    /**
     * Generate the cache key used to store an OTP token.
     *
     * @param string $recipient The OTP recipient.
     * @param string|null $purpose The purpose of the OTP token.
     *
     * @return string The generated OTP token cache key.
     */
    public function generateTokenKey(string $recipient, ?string $purpose = null): string 
    {
        $purpose = $purpose ?? config('otp.token_purpose');

        $key = sprintf(
            'otp:%s:%s',
            $purpose,
            $recipient
        );

        return $key;
    }

    /**
     * Get the remaining lifetime of an OTP token in seconds.
     *
     * @param string $recipient The OTP recipient.
     * @param string|null $purpose The purpose of the OTP token.
     *
     * @return int The remaining lifetime in seconds, or 0 if the token does not exist.
     */
    public function timeToLive(string $recipient,?string $purpose = null): int 
    {
        $key = $this->generateTokenKey(
            recipient: $recipient,
            purpose: $purpose
        );

        if (! Cache::has($key)) {
            return 0;
        }

        $cache = Cache::get($key);
        $expireAt = $cache['expire_at'];
        $remaining = $expireAt - time();

        return $remaining;
    }

   /**
    * Handle dynamic calls to the OTP issuance and verification methods.
    *
    * Validates the recipient and routes the call to the appropriate OTP context.
    *
    * @param string $name The called method name.
    * @param array $arguments The arguments passed to the method.
    *
    * @return OtpIssuance|OtpVerfication
    *
    * @throws OtpBadMethodCallException If the called method is not supported.
    */
    public function __call($name, $arguments)
    {
        if (!in_array($name, ['to', 'from'])) {
            throw new OtpBadMethodCallException(method: $name);
        }

        $this->recipient = $arguments[0];

        return match ($name) {
            'to' => $this->issuance(),
            'from' => $this->verification(),
        };
    }
}