<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('patient_documents')) {
            Schema::create('patient_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('doctor_id')->nullable();
                $table->unsignedBigInteger('appointment_id')->nullable();
                $table->string('title')->nullable();
                $table->string('document_type')->default('medical_report');
                $table->string('file_path');
                $table->string('file_name')->nullable();
                $table->string('file_size')->nullable();
                $table->string('file_type')->nullable();
                $table->text('description')->nullable();
                $table->string('status')->default('submitted');
                $table->timestamps();

                $table->index('patient_id');
                $table->index('doctor_id');
                $table->index('appointment_id');
                $table->index('document_type');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_documents');
    }
};
