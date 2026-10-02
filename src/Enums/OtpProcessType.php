<?php

namespace Abolaradev\Otp\Enums;

enum OtpProcessType: string
{
    case Issuance = 'issuance';
    case Verification = 'verification';
}