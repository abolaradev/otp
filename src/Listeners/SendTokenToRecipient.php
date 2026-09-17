<?php

namespace Abolaradev\Otp\Listeners;

use Abolaradev\Otp\Events\TokenGenerated;
use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTokenToRecipient
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TokenGenerated $event): void
    {
        $otpDetails = $event->otpDetails;
    
        Notification::route('recipient',$otpDetails->getRecipient())
                    ->notify(new OtpNotification($otpDetails));
    }
}