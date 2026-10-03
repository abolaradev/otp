<?php

namespace Abolaradev\Otp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;

class MakeOtpChannelCommand extends Command
{
    protected $signature = "otp:channel {channel}";

    protected $description = "Create a new OTP notification channel.";

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

        use Abolaradev\Otp\Contracts\ShouldOtpChannel;
        use Abolaradev\Otp\Notifications\OtpNotification;

        class {$channelClassName} implements ShouldOtpChannel
        {
            /**
             * Send the OTP notification through the custom OTP channel.
             *
             * Resolves the OTP payload from the notification and provides access
             * to the recipient and OTP token for custom delivery implementation.
             *
             * @param object \$notifiable The entity receiving the notification.
             * @param OtpNotification \$notification The OTP notification instance.
             *
             * @return void
             */
            public function send(object \$notifiable, OtpNotification \$notification): void
            {
               \$otp = \$notification->toOtpPayload(\$notifiable);
               \$recipient = \$otp->getRecipient();
               \$token = \$otp->getToken();

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

        if (!File::isDirectory($channelDirectory)) {
            File::makeDirectory(
                path: $channelDirectory,
                recursive: true
            );
        }

        $channelPath = Str::of($this->argument('channel'))
                          ->studly()
                          ->start($channelDirectory . DIRECTORY_SEPARATOR)
                          ->finish('.php');

        if(File::isFile($channelPath)) {
            alert('OTP Notification Channel already exists!');
        }else{
            File::put($channelPath,$this->template());
            info('OTP Notification Channel created successfully!');
        }

        note("at: [$channelPath]");

        return self::SUCCESS;
    }
}