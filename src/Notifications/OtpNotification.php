<?php

namespace Abolaradev\Otp\Notifications;

use Abolaradev\Otp\Channels\OtpChannel;
use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Services\OtpStorage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected OtpDetails $otpDetails)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            OtpChannel::class
        ];
    }

    /**
     * Get the OTP details payload for the notification.
     *
     * @param object $notifiable The entity receiving the notification.
     *
     * @return OtpDetails The OTP details.
     */
    public function toOtpPayload(object $notifiable) :OtpDetails
    {
        return $this->otpDetails;
    }

    /**
     * Handle the notification after it has been sent.
     */
    public function afterSending(object $notifiable, string $channel, mixed $response): void
    {
         (new OtpStorage($this->otpDetails))->storeToken();
    }
}
