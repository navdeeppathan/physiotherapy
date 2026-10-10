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
        if (!Schema::hasTable('hero_banners')) {
            Schema::create('hero_banners', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('time')->nullable()->comment('Time or subtitle / timing badge');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('button_text')->nullable()->default('Book Appointment');
                $table->string('button_link')->nullable()->default('#search-bar');
                $table->string('button_text_2')->nullable()->default('Find Physiotherapist');
                $table->string('button_link_2')->nullable()->default('#specialists');
                $table->integer('order')->default(0);
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
