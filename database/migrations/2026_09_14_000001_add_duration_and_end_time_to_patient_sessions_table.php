<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('patient_sessions')) {
            Schema::table('patient_sessions', function (Blueprint $table) {
                if (!Schema::hasColumn('patient_sessions', 'end_time')) {
                    $table->time('end_time')->nullable()->after('session_time');
                }
                if (!Schema::hasColumn('patient_sessions', 'duration')) {
                    $table->integer('duration')->nullable()->after('session_time')->comment('Duration in minutes');
                }
            });
        }

        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'duration')) {
                    $table->integer('duration')->nullable()->after('end_time')->comment('Duration in minutes');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('patient_sessions')) {
            Schema::table('patient_sessions', function (Blueprint $table) {
                if (Schema::hasColumn('patient_sessions', 'duration')) {
                    $table->dropColumn('duration');
                }
                if (Schema::hasColumn('patient_sessions', 'end_time')) {
                    $table->dropColumn('end_time');
                }
            });
        }

        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'duration')) {
                    $table->dropColumn('duration');
                }
            });
        }
    }
};
