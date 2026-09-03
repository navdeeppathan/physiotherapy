<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('assessment_parameters') && !Schema::hasColumn('assessment_parameters', 'current_value')) {
            Schema::table('assessment_parameters', function (Blueprint $table) {
                $table->decimal('current_value', 8, 2)->nullable()->after('baseline_value');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('assessment_parameters') && Schema::hasColumn('assessment_parameters', 'current_value')) {
            Schema::table('assessment_parameters', function (Blueprint $table) {
                $table->dropColumn('current_value');
            });
        }
    }
};
