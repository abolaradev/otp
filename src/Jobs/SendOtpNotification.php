<?php

namespace Abolaradev\Otp\Jobs;

use Abolaradev\Otp\Notifications\OtpNotification;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOtpNotification implements ShouldQueue , ShouldBeEncrypted
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $driver, protected object $notifiable , protected OtpNotification $notification
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new $this->driver)->send($this->notifiable, $this->notification);
    }
}
