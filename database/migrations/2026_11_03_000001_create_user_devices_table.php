<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('user_devices')) {
            Schema::create('user_devices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->text('fcm_token');
                $table->string('device_type', 20)->default('android'); // 'android', 'ios', 'web'
                $table->string('device_id', 191)->nullable();           // unique device hardware UUID
                $table->string('device_model', 100)->nullable();        // e.g. Samsung S23, iPhone 14
                $table->string('app_version', 50)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamp('last_used_at')->nullable();
                $table->timestamps();

                $table->index('user_id');
                $table->index('device_type');
                $table->index('device_id');
                $table->index('is_active');
            });
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'fcm_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('fcm_token')->nullable()->after('pincode');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_devices');

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'fcm_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('fcm_token');
            });
        }
    }
};
