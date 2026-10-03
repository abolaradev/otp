# Laravel OTP

A simple and flexible Laravel package for generating, sending, storing, and verifying One-Time Passwords (OTP) through configurable delivery channels.

## Features

* Automatic OTP generation with configurable length and expiration
* Support for different OTP purposes
* Separate APIs for OTP issuance and verification
* Built-in Log, SMS.ir, and Mail channels
* Support for custom OTP channels
* Securely hash OTP tokens before storing them in cache
* Prevent issuing a new OTP while an active token exists
* Built-in rate limiting for OTP issuance and verification
* Localized and customizable OTP exceptions
* Retrieve the remaining TTL of an active OTP
* Built-in Blade Timer Component for OTP countdown

## Installation

Install the package using Composer:

```bash
composer require abolaradev/otp
```

Publish the package configuration:

```bash
php artisan vendor:publish --tag='otp-config'
```

Install the built-in OTP channels and logger:

```bash
php artisan otp:install
```

The `otp:install` command installs the built-in channel classes into your application and creates:

```text
storage/logs/otp.log
```

You only need to register the `otp` logger in `config/logging.php`:

```php
'channels' => [
    'otp' => [
        'driver' => 'single',
        'path' => storage_path('logs/otp.log'),
        'level' => env('LOG_LEVEL', 'debug'),
    ],
],
```

## Configuration

After publishing the configuration file, you can configure the package through `config/otp.php`:

```php
<?php

use App\Channels\LogChannel;
use App\Channels\MailChannel;
use App\Channels\SmsIrChannel;

return [

    'default' => env('OTP_DEFAULT_CHANNEL', 'log'),

    'token_length' => env('OTP_TOKEN_LENGTH', 6),

    'token_purpose' => env('OTP_TOKEN_PURPOSE', 'default'),

    'token_expiration' => env('OTP_TOKEN_EXPIRATION', 120),

    'rate_limiter' => [
        'max_attempts' => env('OTP_RATE_LIMIT_MAX_ATTEMPTS', 5),
        'decay_seconds' => env('OTP_RATE_LIMIT_DECAY_SECONDS', 3600),
    ],

    'channels' => [

        'log' => [
            'driver' => LogChannel::class,
        ],

        'sms' => [
            'smsir' => [
                'driver' => SmsIrChannel::class,
                'api_key' => env('SMSIR_API_KEY'),
                'template_id' => env('SMSIR_TEMPLATE_ID'),
            ],
        ],

        'mail' => [
            'driver' => MailChannel::class,
        ],

    ],

];
```

## Usage

### Sending an OTP

```php
use Abolaradev\Otp\Facades\Otp;

Otp::to('09123457890')
    ->dispatch();
```

The OTP code is generated automatically during dispatch.

### Setting the OTP Length

```php
Otp::to('09123457890')
    ->length(5)
    ->dispatch();
```

Leading zeros are supported.

### Setting the OTP Expiration

The expiration time is specified in seconds:

```php
Otp::to('09123457890')
    ->expiration(180)
    ->dispatch();
```

### Setting the OTP Purpose

```php
Otp::to('09123457890')
    ->purpose('login')
    ->dispatch();
```

### Selecting a Channel

```php
Otp::to('09123457890')
    ->channel('smsir')
    ->dispatch();
```

These options can also be configured globally in `config/otp.php`.

## Verifying an OTP

```php
Otp::from('09123457890')
    ->purpose('login')
    ->token('123456')
    ->verify();
```

After successful verification, the OTP is consumed and cannot be reused.

# Channels

The package provides the following built-in channels:

* **Log** — stores OTP information in `storage/logs/otp.log`
* **SMS.ir** — sends OTP messages through SMS.ir
* **Mail** — sends OTP messages through Laravel's mail notification system

The built-in channels are installed using:

```bash
php artisan otp:install
```

There is no need to publish the channel classes separately.

## Channel Configuration

Channel-specific settings are configured through the `channels` key in `config/otp.php`:

```php
'channels' => [

    'log' => [
        'driver' => LogChannel::class,
    ],

    'sms' => [
        'smsir' => [
            'driver' => SmsIrChannel::class,
            'api_key' => env('SMSIR_API_KEY'),
            'template_id' => env('SMSIR_TEMPLATE_ID'),
        ],
    ],

    'mail' => [
        'driver' => MailChannel::class,
    ],

],
```

The default channel can be configured using:

```php
'default' => env('OTP_DEFAULT_CHANNEL', 'log'),
```

# Creating a Custom Channel

Create a custom OTP channel using:

```bash
php artisan otp:channel {your-channel-name}
```

The generated channel class is stored in:

```text
app/Channels
```

The generated class follows this structure:

```php
namespace App\Channels;

use Abolaradev\Otp\Interfaces\ShouldOtpChannel;
use Abolaradev\Otp\Notifications\OtpNotification;

class MySmsChannel implements ShouldOtpChannel
{
    /**
     * Send the OTP notification through the custom OTP channel.
     *
     * Resolves the OTP payload from the notification and provides access
     * to the recipient and OTP token for custom delivery implementation.
     *
     * @param object $notifiable The entity receiving the notification.
     * @param OtpNotification $notification The OTP notification instance.
     *
     * @return void
     */
    public function send( object $notifiable,OtpNotification $notification): void
    {
        $otp = $notification->toOtpPayload($notifiable);

        $recipient = $otp->getRecipient();
        $token = $otp->getToken();

        // Implement the delivery logic for this channel ...
    }
}
```

## Registering a Custom Channel

Add your custom channel to the appropriate channel group in `config/otp.php`.

For example, for a custom SMS channel:

```php
'channels' => [

    'sms' => [

        'smsir' => [
            'driver' => SmsIrChannel::class,
            'api_key' => env('SMSIR_API_KEY'),
            'template_id' => env('SMSIR_TEMPLATE_ID'),
        ],

        'mysms' => [
            'driver' => MySmsChannel::class,
        ],

    ],

],
```

Then use the channel when dispatching an OTP:

```php
Otp::to('09123457890')
    ->channel('mysms')
    ->dispatch();
```

You can also make your custom channel the default:

```php
'default' => env('OTP_DEFAULT_CHANNEL', 'mysms'),
```

# Rate Limiting

Rate limiting is applied separately to OTP issuance and verification.

Configure the limits in `config/otp.php`:

```php
'rate_limiter' => [
    'max_attempts' => env('OTP_RATE_LIMIT_MAX_ATTEMPTS', 5),
    'decay_seconds' => env('OTP_RATE_LIMIT_DECAY_SECONDS', 3600),
],
```

The limit is checked independently for:

* OTP issuance
* OTP verification

# Exceptions

OTP operations throw `OtpException` when an error occurs.

```php
try {
    Otp::to('09123457890')->dispatch();
} catch (OtpException $e) {
    $this->addError('recipient', $e->getMessage());
}
```

### Customizing Exception Messages

Publish the language files:

```bash
php artisan vendor:publish --tag='otp-lang'
```

Language files are available under:

```text
lang/vendor/otp/en/exceptions.php
lang/vendor/otp/fa/exceptions.php
```

You can also retrieve a translated message:

```php
$e->getTranslatedMessage(locale: 'fa');
```

# OTP Timer

Publish the required assets:

```bash
php artisan vendor:publish --tag='otp-assets'
```

Get the remaining OTP TTL:

```php
$this->ttl = Otp::timeToLive(
    '09123457890',
    'login'
);
```

Then use the Blade component:

```blade
<x-otp::timer :ttl="$ttl" />
```

To display only the remaining seconds:

```blade
<x-otp::timer :ttl="$ttl" secondsOnly />
```

---

If you find this package useful, please don't forget to give it a ⭐ on GitHub. ❤️

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) for information on how to report security vulnerabilities.

## Credits

* [abolaradev](https://github.com/abolaradev)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
