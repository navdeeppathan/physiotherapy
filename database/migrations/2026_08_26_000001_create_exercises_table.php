<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('category')->nullable(); // back, knee, shoulder, etc.
            $table->unsignedBigInteger('specialization_id')->nullable(); // link to specializations
            $table->integer('sets_default')->default(3);
            $table->integer('reps_default')->default(10);
            $table->string('duration_default')->nullable(); // e.g. "30 sec"
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
