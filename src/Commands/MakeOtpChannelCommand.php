<?php

namespace Abolaradev\Otp\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;

#[Signature('make:otp-channel {channel}')]
#[Description('Create a new OTP notification channel.')]
class MakeOtpChannelCommand extends Command
{
    /**
     * Generate the template for the OTP notification channel class.
     *
     * @return string The generated PHP class template.
     */
    protected function template(): string
    {
        $channelClassName = Str::studly($this->argument('channel'));

        return <<<php
        <?php

        namespace App\Channels;

        use Abolaradev\Otp\Interfaces\ShouldSmsChannel;
        use Abolaradev\Otp\Notifications\OtpNotification;

        class {$channelClassName} implements ShouldSmsChannel
        {
            /**
             * Send the OTP notification through the custom SMS channel.
             *
             * Resolves the SMS payload from the notification and provides access
             * to the recipient and OTP token for custom message delivery.
             *
             * @param object \$notifiable The entity receiving the notification.
             * @param OtpNotification \$notification The OTP notification instance.
             *
             * @return void
             */
            public function send(object \$notifiable, OtpNotification \$notification): void
            {
               \$sms = \$notification->toSMS(\$notifiable);
               \$recipient = \$sms->getRecipient();
               \$token = \$sms->getToken();

               // Implement the SMS delivery logic for this channel ...
            }
        }
        php;
    }

    /**
     * Execute the OTP notification channel creation command.
     *
     * Creates the Channels directory when it does not exist and generates
     * the requested OTP notification channel class.
     *
     * @return int The command exit status.
     */
    public function handle(): int
    {
        $channelDirectory = app_path('Channels');

        if (!is_dir($channelDirectory)) {
            mkdir(
                directory: $channelDirectory,
                permissions: 0775,
                recursive: true
            );
        }

        $channelPath = Str::of($this->argument('channel'))
                          ->studly()
                          ->start($channelDirectory . DIRECTORY_SEPARATOR)
                          ->finish('.php');

        if(is_file($channelPath)) {
            alert('OTP Notification Channel already exists!');
        }else{
            file_put_contents($channelPath, $this->template());
            info('OTP Notification Channel created successfully!');
        }

        note("at: [$channelPath]");

        return self::SUCCESS;
    }
}