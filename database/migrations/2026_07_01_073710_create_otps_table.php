<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identifier
            |--------------------------------------------------------------------------
            |
            | Can be email, phone, username etc.
            |
            */

            $table->string('identifier');

            /*
            |--------------------------------------------------------------------------
            | Type
            |--------------------------------------------------------------------------
            |
            | email
            | phone
            |
            */

            $table->string('type',20)->default('email');

            /*
            |--------------------------------------------------------------------------
            | Purpose
            |--------------------------------------------------------------------------
            */

            $table->string('purpose',50);

            /*
            |--------------------------------------------------------------------------
            | OTP
            |--------------------------------------------------------------------------
            */

            $table->string('otp');

            /*
            |--------------------------------------------------------------------------
            | Expiry
            |--------------------------------------------------------------------------
            */

            $table->timestamp('expires_at');

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->timestamp('verified_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('attempts')->default(0);

            $table->unsignedTinyInteger('resend_count')->default(0);

            $table->timestamp('last_resend_at')->nullable();

            $table->timestamps();

            $table->index([
                'identifier',
                'purpose'
            ]);

            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};