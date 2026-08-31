<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();           // e.g. pain_score, lumbar_flexion
            $table->string('label');                  // e.g. "Pain Score (0–10)"
            $table->string('unit')->nullable();       // e.g. score, °, min, %, grade
            $table->string('icon')->nullable();       // relative or absolute path / url
            $table->string('icon_key')->nullable();   // slug for mobile vector mapping
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_parameters');
    }
};
