<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorDocument extends Model
{
    protected $table = 'doctor_documents';

    protected $fillable = [
        'user_id',
        'document_type',
        'document_path',
        'verification_status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Document belongs to DoctorProfile
     */
    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}