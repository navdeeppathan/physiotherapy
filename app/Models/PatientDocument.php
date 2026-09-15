<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PatientDocument extends Model
{
    use HasFactory;

    protected $table = 'patient_documents';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'title',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'description',
        'status',
    ];

    protected $appends = [
        'file_url',
        'formatted_file_size',
    ];

    /**
     * Self-healing: ensure table exists automatically if not yet migrated
     */
    public static function ensureTableExists(): void
    {
        static $checked = false;
        if ($checked) return;
        $checked = true;

        try {
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
        } catch (\Exception $e) {
            // Ignore if exists or permissions issue
        }
    }

    /**
     * Patient relationship
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Doctor relationship (optional)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Appointment relationship (optional)
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    /**
     * Accessor for full file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }

        return asset($this->file_path);
    }

    /**
     * Accessor for human-readable file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes <= 0) {
            return 'N/A';
        }

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }
}
