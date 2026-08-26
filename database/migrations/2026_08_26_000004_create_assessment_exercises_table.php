<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_exercises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->unsignedBigInteger('exercise_id');
            $table->integer('sets')->default(3);
            $table->integer('reps')->default(10);
            $table->string('duration')->nullable(); // alternative to reps
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('assessment_id')->references('id')->on('patient_assessments')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_exercises');
    }
};
