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
     * e.g., PLN-20260907-P11-9A8B-482
     */
    public static function generateUniquePlanId($patientId = null): string
    {
        $dateStr  = date('Ymd');
        $patStr   = $patientId ? "P{$patientId}" : 'PAT';
        $randHex  = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $rand3Num = rand(100, 999);
        return "PLN-{$dateStr}-{$patStr}-{$randHex}-{$rand3Num}";
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