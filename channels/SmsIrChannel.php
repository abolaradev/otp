<?php

namespace App\Channels;

use Abolaradev\Otp\Interfaces\ShouldSmsChannel;
use Abolaradev\Otp\Notifications\OtpNotification;
use Ipe\Sdk\Facades\SmsIr;

class SmsIrChannel implements ShouldSmsChannel
{
    /**
     * Send the OTP notification through the custom SMS channel.
     *
     * Resolves the SMS payload from the notification and provides access
     * to the recipient and OTP token for custom message delivery.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     */
    public function send(object $notifiable, OtpNotification $notification): void
    {
       $sms = $notification->toSMS($notifiable);
       $recipient = $sms->getRecipient();
       $token = $sms->getToken();

       $templateId = config('otp.channels.smsir.template_id');
       $parameters = [
            [
                "name" => "Code",
                "value" => $token
            ]
        ];

       $response = SmsIr::verifySend($recipient, $templateId, $parameters);
    }
}