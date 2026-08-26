<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAssessment extends Model
{
    use HasFactory;

    protected $table = 'patient_assessments';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'specialization_id',
        'baseline_score',
        'goal_text',
        'goal_duration_weeks',
        'total_sessions',
        'completed_sessions',
        'assessment_date',
        'next_session_date',
        'status',
    ];

    protected $casts = [
        'assessment_date'   => 'date',
        'next_session_date' => 'date',
        'baseline_score'    => 'float',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function condition()
    {
        return $this->belongsTo(Specializations::class, 'specialization_id');
    }

    public function parameters()
    {
        return $this->hasMany(AssessmentParameter::class, 'assessment_id')->orderBy('sort_order');
    }

    public function exercises()
    {
        return $this->hasMany(AssessmentExercise::class, 'assessment_id')->orderBy('sort_order');
    }

    public function goals()
    {
        return $this->hasMany(AssessmentGoal::class, 'assessment_id')->orderBy('sort_order');
    }

    public function sessions()
    {
        return $this->hasMany(PatientSession::class, 'assessment_id');
    }

    public function upcomingSessions()
    {
        return $this->hasMany(PatientSession::class, 'assessment_id')
                    ->whereIn('status', ['scheduled']);
    }
}
