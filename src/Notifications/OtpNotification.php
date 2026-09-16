<?php

namespace Abolaradev\Otp\Notifications;

use Abolaradev\Otp\Channels\SmsChannel;
use Abolaradev\Otp\DTO\TokenDetails;
use Abolaradev\Otp\Services\OtpStorage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OtpNotification extends Notification
{
    use Queueable;

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
     * Handle the notification after it has been sent.
     */
    public function afterSending(object $notifiable, string $channel, mixed $response): void
    {
         $route = $notifiable->routeNotificationFor('sms');

         (new OtpStorage($route))->hash()
                                 ->cache();

    }
}
