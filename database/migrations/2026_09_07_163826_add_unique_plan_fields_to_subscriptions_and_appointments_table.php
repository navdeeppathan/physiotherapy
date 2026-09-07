<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('patient_plan_subscriptions')) {
            Schema::table('patient_plan_subscriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('patient_plan_subscriptions', 'unique_plan_id')) {
                    $table->string('unique_plan_id', 100)->nullable()->unique()->after('id');
                }
            });
        }

        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'patient_plan_id')) {
                    $table->unsignedBigInteger('patient_plan_id')->nullable()->after('patient_id');
                }
                if (!Schema::hasColumn('appointments', 'patient_plan_subscription_id')) {
                    $table->unsignedBigInteger('patient_plan_subscription_id')->nullable()->after('patient_plan_id');
                }
                if (!Schema::hasColumn('appointments', 'unique_plan_id')) {
                    $table->string('unique_plan_id', 100)->nullable()->after('patient_plan_subscription_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('patient_plan_subscriptions')) {
            Schema::table('patient_plan_subscriptions', function (Blueprint $table) {
                if (Schema::hasColumn('patient_plan_subscriptions', 'unique_plan_id')) {
                    $table->dropColumn('unique_plan_id');
                }
            });
        }

        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('appointments', 'unique_plan_id')) {
                    $columns[] = 'unique_plan_id';
                }
                if (Schema::hasColumn('appointments', 'patient_plan_subscription_id')) {
                    $columns[] = 'patient_plan_subscription_id';
                }
                if (Schema::hasColumn('appointments', 'patient_plan_id')) {
                    $columns[] = 'patient_plan_id';
                }
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
