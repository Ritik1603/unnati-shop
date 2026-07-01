<?php

namespace App\Services\Auth;

use App\Models\PendingRegistration;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    public function createPendingRegistration(array $data, string $otp): PendingRegistration
    {
        PendingRegistration::where('email', $data['email'])->delete();

        return PendingRegistration::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'otp' => app(OtpService::class)->hash($otp),
            'otp_expires_at' => now()->addMinutes(config('otp.expiry_minutes')),
            'attempts' => 0,
            'resend_count' => 0,
            'last_resend_at' => now(),
        ]);
    }
}