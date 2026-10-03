<?php

namespace App\Channels;

use Abolaradev\Otp\Contracts\ShouldOtpChannel;
use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class MailChannel implements ShouldOtpChannel
{
    /**
     * Send the OTP notification through the configured mail channel.
     *
     * Resolves the OTP payload from the notification and sends the
     * verification token to the recipient via email.
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

        Mail::send("view:name", ['token' => $token], function (Message $message) use ($recipient) {
            $message->to($recipient)
                    ->subject('otp verification');
        });
    }
}