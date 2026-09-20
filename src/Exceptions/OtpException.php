<?php

namespace Abolaradev\Otp\Exceptions;

use Exception;

abstract class OtpException extends Exception
{
   protected array $replace = [];
   
   /**
    * Create a new OTP exception with its translated message.
    */
   public function __construct()
   {
      parent::__construct(__(
         key: $this->getMessageKey(),
         replace: $this->replace
      ));
   }

   /**
    * Get the translated exception message for the given locale.
    *
    * @param string $locale The locale used to translate the message.
    * @return string
    */
   public function getTranslatedMessage(string $locale = 'fa'): string
   {
      return __(
         key: $this->getMessageKey(),
         replace: $this->replace,
         locale: $locale
      );
   }

   /**
    * Get the translation key for the exception message.
    *
    * @return string
    */
   abstract protected function getMessageKey(): string;
}