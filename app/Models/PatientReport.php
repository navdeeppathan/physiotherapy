<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    use HasFactory;

    protected $table = 'patient_reports';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'assessment_id',
        'period_type',
        'start_date',
        'end_date',
        'overall_improvement_pct',
        'sessions_completed',
        'total_sessions',
        'goals_achieved',
        'total_goals',
        'report_data',
        'share_token',
        'share_expires_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'report_data' => 'array',
        'overall_improvement_pct' => 'float',
        'share_expires_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function assessment()
    {
        return $this->belongsTo(PatientAssessment::class, 'assessment_id');
    }
}
