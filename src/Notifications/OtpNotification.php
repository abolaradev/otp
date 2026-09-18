<?php

namespace Abolaradev\Otp\Notifications;

use Abolaradev\Otp\DTOs\OtpDetails;
use Abolaradev\Otp\Channels\SmsChannel;
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
            SmsChannel::class
        ];
    }

    /**
     * Provides the OTP details required by the SMS notification channel.
     *
     * @param  mixed $notifiable
     * @return OtpDetails
     */
    public function toSMS(object $notifiable) :OtpDetails
    {
        return $this->otpDetails;
    }

    /**
     * Handle the notification after it has been sent.
     */
    public function afterSending(object $notifiable, string $channel, mixed $response): void
    {
         (new OtpStorage($this->otpDetails))->hash()->cache();
    }
}
