<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PendingRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'otp',
        'otp_expires_at',
        'attempts',
        'resend_count',
        'last_resend_at',
    ];

    protected function casts(): array
    {
        return [
            'otp_expires_at' => 'datetime',
            'last_resend_at' => 'datetime',
        ];
    }

    /**
     * Check whether OTP has expired.
     */
    public function isOtpExpired(): bool
    {
        return Carbon::now()->greaterThan($this->otp_expires_at);
    }

    /**
     * Check verification attempts.
     */
    public function hasExceededAttempts(): bool
    {
        return $this->attempts >= config('otp.max_attempts');
    }

    /**
     * Check resend limit.
     */
    public function hasExceededResends(): bool
    {
        return $this->resend_count >= config('otp.max_resends');
    }

    /**
     * Check resend cooldown.
     */
    public function canResend(): bool
    {
        if (!$this->last_resend_at) {
            return true;
        }

        return now()->diffInSeconds($this->last_resend_at)
            >= config('otp.resend_after_seconds');
    }
}