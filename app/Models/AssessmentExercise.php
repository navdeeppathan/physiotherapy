<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentExercise extends Model
{
    use HasFactory;

    protected $table = 'assessment_exercises';

    protected $fillable = [
        'assessment_id',
        'exercise_id',
        'sets',
        'reps',
        'duration',
        'sort_order',
    ];

    public function assessment()
    {
        return $this->belongsTo(PatientAssessment::class, 'assessment_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
