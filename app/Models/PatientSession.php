<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSession extends Model
{
    use HasFactory;

    protected $table = 'patient_sessions';

    protected $fillable = [
        'assessment_id',
        'doctor_id',
        'patient_id',
        'session_date',
        'session_time',
        'session_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function assessment()
    {
        return $this->belongsTo(PatientAssessment::class, 'assessment_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
