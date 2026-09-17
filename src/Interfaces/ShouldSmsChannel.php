<?php

namespace Abolaradev\Otp\Interfaces;

use Abolaradev\Otp\Notifications\OtpNotification;

/**
 * Defines the contract for OTP SMS notification channels.
 *
 * Implementations are responsible for sending an OTP notification
 * through a specific SMS provider or delivery mechanism.
 */
interface ShouldSmsChannel
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