<?php

namespace Abolaradev\Otp\Channels;

use Abolaradev\Otp\Contracts\ShouldOtpChannel;
use Abolaradev\Otp\Exceptions\OtpInvalidChannelException;
use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Support\Arr;

class OtpChannel implements ShouldOtpChannel
{
    /**
     * Send the OTP notification through the configured OTP channel.
     *
     * Resolves the requested OTP channel from the package configuration,
     * validates the channel driver class, and delegates the notification
     * sending to the resolved channel implementation.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     *
     * @throws OtpInvalidChannelException If the requested channel or its driver is invalid.
     */
    public function send(object $notifiable, OtpNotification $notification): void
    {
        $channel = $notification->toOtpPayload($notifiable)
                                ->getChannel();

        $channels = config('otp.channels');

        if (! Arr::has($channels, $channel)) {
            $channels = Arr::collapse($channels);
        }

        $driver = Arr::get($channels, "$channel.driver");

        if (
            is_null($driver) ||
            ! class_exists($driver) ||
            ! is_subclass_of($driver, ShouldOtpChannel::class)
        ) {
            throw new OtpInvalidChannelException($channel);
        }

        (new $driver)->send($notifiable, $notification);
    }
}