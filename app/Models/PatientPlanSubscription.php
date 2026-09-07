<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPlanSubscription extends Model
{
    use HasFactory;

    protected $table = 'patient_plan_subscriptions';

    protected $fillable = [
        'unique_plan_id',
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

    /**
     * Generate unique plan ID
     * e.g., PLN-20260907-P11-9A8B
     */
    public static function generateUniquePlanId($patientId = null): string
    {
        $dateStr = date('Ymd');
        $patStr  = $patientId ? "P{$patientId}" : 'PAT';
        $randStr = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        return "PLN-{$dateStr}-{$patStr}-{$randStr}";
    }

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

    // Appointments booked under this unique plan purchase
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_plan_subscription_id');
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