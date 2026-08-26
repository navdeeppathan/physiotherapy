<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('assessment_id')->nullable();
            $table->string('period_type')->default('15_days'); // 7_days, 15_days, 30_days, custom
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('overall_improvement_pct', 5, 2)->default(0);
            $table->integer('sessions_completed')->default(0);
            $table->integer('total_sessions')->default(0);
            $table->integer('goals_achieved')->default(0);
            $table->integer('total_goals')->default(0);
            $table->json('report_data')->nullable(); // full report snapshot
            $table->string('share_token', 64)->nullable()->unique();
            $table->timestamp('share_expires_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assessment_id')->references('id')->on('patient_assessments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_reports');
    }
};
