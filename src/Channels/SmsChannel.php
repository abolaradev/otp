<?php

namespace Abolaradev\Otp\Channels;

use Abolaradev\Otp\Exceptions\OtpInvalidChannelException;
use Abolaradev\Otp\Interfaces\ShouldSmsChannel;
use Abolaradev\Otp\Notifications\OtpNotification;

class SmsChannel implements ShouldSmsChannel
{
    /**
     * Send the OTP notification through the configured SMS channel.
     *
     * Resolves the default SMS channel from the package configuration,
     * validates the channel class, and delegates the notification sending
     * to the resolved channel implementation.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     *
     * @throws OtpInvalidChannelException If the configured channel is invalid.
     */
    public function send(object $notifiable, OtpNotification $notification): void
    {
        $defaultChannel = config('otp.default');
        $channelClass = config("otp.channels.$defaultChannel");

        if (! class_exists($channelClass) ||! is_subclass_of($channelClass, ShouldSmsChannel::class) ) {
            throw new OtpInvalidChannelException($channelClass);
        }

        (new $channelClass)->send($notifiable, $notification);
    }
}