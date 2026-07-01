<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;

class OtpService
{
    /**
     * Generate a numeric OTP.
     */
    public function generate(): string
    {
        $length = (int) config('otp.length', 6);

        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_pad('', $length, '9');

        return (string) random_int($min, $max);
    }

    /**
     * Hash OTP before storing.
     */
    public function hash(string $otp): string
    {
        return Hash::make($otp);
    }

    /**
     * Verify OTP.
     */
    public function verify(string $otp, string $hashedOtp): bool
    {
        return Hash::check($otp, $hashedOtp);
    }
}