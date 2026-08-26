<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentGoal extends Model
{
    use HasFactory;

    protected $table = 'assessment_goals';

    protected $fillable = [
        'assessment_id',
        'goal_text',
        'sort_order',
    ];

    public function assessment()
    {
        return $this->belongsTo(PatientAssessment::class, 'assessment_id');
    }
}
