# Laravel OTP

A simple and flexible Laravel package for generating, sending, storing, and verifying One-Time Passwords (OTP) through configurable delivery channels.

## Features

* Automatic OTP generation with configurable length and expiration
* Support for different OTP purposes
* Separate APIs for OTP issuance and verification
* Configurable delivery channels
* Built-in Log and SMS.ir channels
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

Then publish the package configuration:

```bash
php artisan vendor:publish --tag='otp-config'
```

## Configuration

After publishing the configuration file, you can configure the package through `config/otp.php`:

```php
<?php

use App\Channels\LogChannel;
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

        'smsir' => [
            'driver' => SmsIrChannel::class,
            'api_key' => env('SMSIR_API_KEY'),
            'template_id' => env('SMSIR_TEMPLATE_ID'),
        ],
    ],
];
```

## Usage

This package provides an `Otp` facade that allows you to manage the OTP generation, delivery, and verification process through a fluent API.

### Sending an OTP

To send an OTP, call the `to` method on the `Otp` facade and provide the recipient's phone number.

Then, call the `dispatch` method to send the OTP:

> The OTP code is generated automatically during the dispatch process.

```php
use Abolaradev\Otp\Facades\Otp;

Otp::to('09123457890')
    ->dispatch();
```

### Setting the OTP Length

Use the `length` method to specify the number of digits in the OTP:

```php
Otp::to('09123457890')
    ->length(5)
    ->dispatch();
```

The package also supports OTPs with leading zeros.

### Setting the OTP Expiration

Use the `expiration` method to specify how long the OTP remains valid. The value is specified in seconds.

```php
Otp::to('09123457890')
    ->expiration(180)
    ->dispatch();
```

### Setting the OTP Purpose

You can assign a purpose to an OTP using the `purpose` method.

This allows you to distinguish OTPs used for different operations, such as login, registration, or password reset.

```php
Otp::to('09123457890')
    ->purpose('login')
    ->dispatch();
```

### Selecting a Channel

If you want to send the OTP through a specific channel, use the `channel` method and provide the channel name:

```php
Otp::to('09123457890')
    ->channel('smsir')
    ->dispatch();
```

You can also configure these options globally in `config/otp.php` without specifying them through the fluent API.

---

## Verifying an OTP

To verify an OTP, call the `from` method on the `Otp` facade and provide the recipient's phone number.

If the OTP belongs to a specific purpose, specify it using the `purpose` method.

The OTP received from the user should be passed to the `token` method.

Finally, call the `verify` method to validate the OTP:

```php
Otp::from('09123457890')
    ->purpose('login')
    ->token('123456')
    ->verify();
```

If the verification is successful, the OTP is considered consumed and cannot be used again.

---

# Channels

Channels are the delivery mechanisms used to send OTP codes to recipients.

This package provides two built-in channels:

### Log Channel

The Log Channel is useful for development environments. It stores the generated OTP along with its recipient in a dedicated `otp.log` file.

### SMS.ir Channel

The SMS.ir Channel integrates with the SMS.ir service and provides a ready-to-use implementation for sending OTP messages through SMS.ir.

## Publishing Channels

Before using the built-in channels, publish the channel classes using:

```bash
php artisan vendor:publish --tag='otp-channels'
```

The channel classes will be published to:

```text
app/channels
```

---

## Configuring the Log Channel

To use the Log Channel, first create the following log file:

```text
storage/logs/otp.log
```

Then register the `otp` logger in `config/logging.php`:

```php
'channels' => [

    'otp' => [
        'driver' => 'single',
        'path' => storage_path('logs/otp.log'),
        'level' => env('LOG_LEVEL', 'debug'),
    ],

],
```

The default channel is configured through the `default` key in `config/otp.php`.

By default, the Log Channel is used:

```php
'default' => env('OTP_DEFAULT_CHANNEL', 'log'),
```

---

## Channel Configuration

Channel-specific settings are configured through the `channels` key in `config/otp.php`:

```php
'channels' => [

    'log' => [
        'driver' => LogChannel::class,
    ],

    'smsir' => [
        'driver' => SmsIrChannel::class,
        'api_key' => env('SMSIR_API_KEY'),
        'template_id' => env('SMSIR_TEMPLATE_ID'),
    ],

],
```

---

# Creating a Custom Channel

You can create your own SMS Channel and configure it according to your application's requirements.

To create a custom OTP channel, use the following Artisan command:

```bash
php artisan make:otp-channel {your-channel-name}
```

The generated Channel Class will be stored in:

```text
app/channels
```

The generated class has the following structure:

```php
use Abolaradev\Otp\Interfaces\ShouldSmsChannel;
use Abolaradev\Otp\Notifications\OtpNotification;

class MySmsChannel implements ShouldSmsChannel
{
    public function send(object $notifiable, OtpNotification $notification): void 
    {
        $sms = $notification->toSMS($notifiable);

        $recipient = $sms->getRecipient();
        $token = $sms->getToken();

        // Implement the SMS delivery logic here...
    }
}
```

The `send` method is responsible for implementing the SMS delivery logic for your custom channel.

The generated OTP token and its recipient are already available through the `OtpNotification` instance.

---

## Registering a Custom Channel

After creating your custom channel, register it in `config/otp.php` under the `channels` key.

First, define a name for your channel and assign your Channel Class to the `driver` key.

You can also define any additional configuration required by your channel:

```php
'channels' => [

    'mysms' => [
        'driver' => MySmsChannel::class,
    ],

],
```

You can then use your custom channel when sending an OTP:

```php
Otp::to('09123457890')
    ->channel('mysms')
    ->dispatch();
```

### Setting a Custom Channel as the Default

You can also configure your custom channel as the default channel:

```php
'default' => env('OTP_DEFAULT_CHANNEL', 'mysms'),
```

This way, you do not need to explicitly specify the channel every time an OTP is dispatched.

---

# Security

OTP tokens are hashed before they are stored in the cache.

The generated token is first sent through the configured delivery channel and is then stored as a hash:

```text
Generated Token
      ↓
Send Token
      ↓
Hash Token
      ↓
Store in Cache
```

The original OTP token is therefore not stored in plain text.

The cache entry is also the source of truth for OTP validity. The `expire_at` value stored alongside the hashed token is used to calculate the remaining TTL, but it does not determine whether the OTP is still valid.

---

# Rate Limiting

The package provides built-in rate limiting for both OTP issuance and verification.

Rate limiting is applied separately to each process. OTP issuance and verification have independent rate limit checks, so reaching the limit for one process does not affect the other.

The limits can be configured through:

```php
    'rate_limiter' => [

        'max_attempts' => env('OTP_RATE_LIMIT_MAX_ATTEMPTS', 5),

        'decay_seconds' => env('OTP_RATE_LIMIT_DECAY_SECONDS', 3600),

    ]
```

For example, the configuration above allows up to 5 attempts within a 3600-second window for each process.

The rate limit is checked independently when:

Issuing an OTP
Verifying an OTP

---

# Exceptions

The `dispatch` and `verify` methods do not return a specific value when the operation is successful.

If an error occurs during the OTP process, an `OtpException` is thrown.

You can handle `OtpException` using a `try-catch` block or your application's exception handling mechanism.

For example in Livewire Component:

```php
try {

    Otp::to('09123457890')
        ->dispatch();

    return $this->redirectRoute(
        'verify.mobile',
        ['mobile' => '09123457890']
    );

} catch (OtpException $e) {

    $this->addError(
        'recipient',
        $e->getMessage()
    );

}
```

## Getting the Exception Message

You can access the exception message using the `getMessage()` method:

```php
try {

    Otp::to('09123457890')
        ->dispatch();

} catch (OtpException $e) {

    $this->addError(
        'recipient',
        $e->getMessage()
    );

}
```

## Customizing Exception Messages

The exception messages can be customized by publishing the package language files:

```bash
php artisan vendor:publish --tag='otp-lang'
```

After publishing the language files, the exception translations will be available in:

```text
lang/vendor/otp/en/exceptions.php
```

```text
lang/vendor/otp/fa/exceptions.php
```

You can modify these messages according to your application's requirements.

### Adding Your Own Locale

You can also create a language file for your own locale.

For example, if your application uses Spanish (`es`), create:

```text
lang/vendor/otp/es/exceptions.php
```

Then define your translated messages:

```php
return [

    'active_token_exists' => 'Ya existe un OTP activo.',

    'invalid_token' => 'El OTP proporcionado no es válido.',

];
```

## Translated Exception Messages

To retrieve a translated exception message, use the `getTranslatedMessage()` method.

The method accepts a `locale` argument that determines the language of the returned message.

The default locale is `fa`:

```php
try {

    Otp::to('09123457890')
        ->dispatch();

} catch (OtpException $e) {

    $this->addError(
        'recipient',
        $e->getTranslatedMessage(locale: 'fa')
    );

}
```

You can provide any available locale:

```php
$e->getTranslatedMessage(locale: 'en');
```

For a custom locale:

```php
$e->getTranslatedMessage(locale: 'es');
```

---

# OTP Timer

This package also provides a Blade Component called `timer`, which allows you to easily display the remaining OTP TTL on your verification page.

First, publish the required assets:

```bash
php artisan vendor:publish --tag='otp-assets'
```

## Getting the OTP TTL

To retrieve the remaining TTL of an OTP, use the `timeToLive` method on the `Otp` facade.

The method accepts the recipient's phone number as its first argument and the OTP purpose as its second argument.

For example in Livewire Component:

```php
public function mount()
{
    $this->ttl = Otp::timeToLive(
        '09123457890',
        'login'
    );
}
```

The method returns the remaining lifetime in seconds.

If there is no active OTP for the given recipient and purpose, it returns `0`.

Then, simply pass the TTL to the `timer` Blade Component:

```blade
<x-otp::timer :ttl="$ttl" />
```

### Seconds Only

By default, the timer displays the remaining time in a formatted representation:

```text
02:00
01:59
01:58
```

If you want the countdown to display only the remaining seconds, add the `secondsOnly` attribute:

```blade
<x-otp::timer :ttl="$ttl" secondsOnly />
```

This displays the countdown as:

```text
120
119
118
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
