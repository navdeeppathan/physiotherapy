<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPlan extends Model
{
    use HasFactory;

    protected $table = 'patient_plans';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'total_appointments',
        'duration',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_appointments' => 'integer',
    ];

    // Optional Scope
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}