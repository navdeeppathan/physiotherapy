<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->string('parameter_key');    // e.g. pain_score, lumbar_flexion
            $table->string('parameter_label');  // e.g. "Pain Score (0-10)"
            $table->string('unit')->nullable(); // e.g. °, min, %, score
            $table->decimal('baseline_value', 8, 2)->nullable();
            $table->decimal('target_value', 8, 2)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('assessment_id')->references('id')->on('patient_assessments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_parameters');
    }
};
