<?php

namespace App\Channels;

use Abolaradev\Otp\Interfaces\ShouldSmsChannel;
use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Support\Facades\Log;

class LogChannel implements ShouldSmsChannel
{
    /**
     * Send the OTP notification through the configured SMS channel.
     *
     * Resolves the SMS data from the notification and logs the verification
     * code along with the recipient.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     */
    public function send(object $notifiable, OtpNotification $notification) :void
    {
        $sms = $notification->toSMS($notifiable);
        $recipient = $sms->getRecipient();
        $token = $sms->getToken();

        Log::channel('otp')
           ->info("your verification code is : $token" , ['recipient'=>$recipient]);
    }
}