<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->text('goal_text');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('assessment_id')->references('id')->on('patient_assessments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_goals');
    }
};
