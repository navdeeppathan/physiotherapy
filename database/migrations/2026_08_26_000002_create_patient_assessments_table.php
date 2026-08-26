<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('specialization_id')->nullable(); // condition from specializations table
            $table->decimal('baseline_score', 5, 2)->nullable();
            $table->text('goal_text')->nullable();
            $table->integer('goal_duration_weeks')->default(8);
            $table->integer('total_sessions')->default(12);
            $table->integer('completed_sessions')->default(0);
            $table->date('assessment_date');
            $table->date('next_session_date')->nullable();
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_assessments');
    }
};
