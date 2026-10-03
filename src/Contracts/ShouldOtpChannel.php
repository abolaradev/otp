<?php

namespace Abolaradev\Otp\Contracts;

use Abolaradev\Otp\Notifications\OtpNotification;

interface ShouldOtpChannel
{
    /**
     * Send the OTP notification.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     */
    public function send(object $notifiable, OtpNotification $notification): void;
}