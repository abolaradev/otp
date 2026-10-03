<?php

namespace App\Channels;

use Abolaradev\Otp\Contracts\ShouldOtpChannel;
use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Support\Facades\Log;

class LogChannel implements ShouldOtpChannel
{
    /**
     * Send the OTP notification through the configured OTP log channel.
     *
     * Resolves the OTP payload from the notification and logs the
     * verification token along with the recipient information.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     */
    public function send(object $notifiable, OtpNotification $notification): void
    {
        $otp = $notification->toOtpPayload($notifiable);
        $recipient = $otp->getRecipient();
        $token = $otp->getToken();

        Log::channel('otp')
           ->info("your verification code is : $token", ['recipient' => $recipient]);
    }
}