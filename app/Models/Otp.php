<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [

        'identifier',

        'type',

        'purpose',

        'otp',

        'expires_at',

        'verified_at',

        'attempts',

        'resend_count',

        'last_resend_at',

    ];

    protected function casts(): array
    {
        return [

            'expires_at' => 'datetime',

            'verified_at' => 'datetime',

            'last_resend_at' => 'datetime',

        ];
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function canResend(): bool
    {
        if (!$this->last_resend_at) {
            return true;
        }

        return now()->diffInSeconds($this->last_resend_at)
            >= config('otp.resend_after_seconds');
    }
}