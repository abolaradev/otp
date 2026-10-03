<?php

namespace Abolaradev\Otp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\info;
use function Orchestra\Sidekick\working_path;

class OtpInstallCommand extends Command
{
    protected $signature = "otp:install1";

    protected $description = "Install the default OTP channels into the application";

    /**
     * Install the default OTP channels and logger.
     *
     * Copies the default OTP channel implementations to the application's
     * Channels directory and creates the OTP log file.
     *
     * @return void
     */
    public function handle(): void
    {
        $channels = working_path('channels');
        $app = app_path('Channels');
        $otpLogger = storage_path('logs/otp.log');

        File::copyDirectory($channels,$app);

        File::put($otpLogger,'');

        info('OTP channels and logger have been successfully installed.');
    }
}