<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Sanitize empty phone numbers to NULL to prevent duplicate key errors on empty strings
        try {
            DB::statement("UPDATE users SET phone = NULL WHERE phone = '' OR phone = 'null' OR phone = 'NULL'");
        } catch (\Throwable $e) {}

        // 2. Sanitize empty emails to NULL
        try {
            DB::statement("UPDATE users SET email = NULL WHERE email = '' OR email = 'null' OR email = 'NULL'");
        } catch (\Throwable $e) {}

        // 3. Add unique index on phone if it doesn't already exist
        try {
            $existingPhoneIdx = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_phone_unique'");
            if (empty($existingPhoneIdx)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('phone', 'users_phone_unique');
                });
            }
        } catch (\Throwable $e) {}

        // 4. Ensure unique index on email if it doesn't already exist
        try {
            $existingEmailIdx = DB::select("SHOW INDEX FROM users WHERE Column_name = 'email' AND Non_unique = 0");
            if (empty($existingEmailIdx)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('email', 'users_email_unique');
                });
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_phone_unique');
            });
        } catch (\Throwable $e) {}
    }
};
