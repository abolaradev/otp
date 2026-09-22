<?php 

function otp_asset(string $path)
{
    $filePath = public_path("vendor/otp/$path");

    return file_exists($filePath)
           ? asset("vendor/otp/$path")
           : url()->query("assets/$path" ,['ver'=>time()]);
}
