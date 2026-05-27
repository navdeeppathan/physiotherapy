<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPlanSubscription extends Model
{
    use HasFactory;

    protected $table = 'patient_plan_subscriptions';

    protected $fillable = [
        'patient_id',
        'patient_plan_id',
        'start_date',
        'end_date',
        'used_appointments',
        'remaining_appointments',
        'payment_status',
        'payment_method',
        'transaction_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'used_appointments' => 'integer',
        'remaining_appointments' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Patient Relation
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Plan Relation
    public function plan()
    {
        return $this->belongsTo(PatientPlan::class, 'patient_plan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}