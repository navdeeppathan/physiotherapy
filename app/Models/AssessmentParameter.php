<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentParameter extends Model
{
    use HasFactory;

    protected $table = 'assessment_parameters';

    protected $fillable = [
        'assessment_id',
        'parameter_key',
        'parameter_label',
        'unit',
        'baseline_value',
        'current_value',
        'target_value',
        'sort_order',
    ];

    protected $casts = [
        'baseline_value' => 'float',
        'current_value'  => 'float',
        'target_value'   => 'float',
    ];

    public function assessment()
    {
        return $this->belongsTo(PatientAssessment::class, 'assessment_id');
    }
}
