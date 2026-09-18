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
        'doctor_id',
        'patient_plan_id',
        'start_date',
        'end_date',
        'used_appointments',
        'remaining_appointments',
        'doctor_fee',
        'admin_fee',
        'admin_fee_type',
        'package_price',
        'package_appointments',
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
        'package_appointments' => 'integer',
        'doctor_fee' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'package_price' => 'decimal:2',
    ];

    /**
     * Self-healing: Ensure accounting columns exist in patient_plan_subscriptions
     */
    public static function ensureSchema(): void
    {
        static $checked = false;
        if ($checked) return;
        $checked = true;

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('patient_plan_subscriptions')) {
                \Illuminate\Support\Facades\Schema::table('patient_plan_subscriptions', function (\Illuminate\Database\Schema\Blueprint $table) {
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'doctor_id')) {
                        $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'doctor_fee')) {
                        $table->decimal('doctor_fee', 10, 2)->nullable()->default(0)->after('remaining_appointments');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'admin_fee')) {
                        $table->decimal('admin_fee', 10, 2)->nullable()->default(0)->after('doctor_fee');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'admin_fee_type')) {
                        $table->string('admin_fee_type', 20)->default('fixed')->after('admin_fee');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'package_price')) {
                        $table->decimal('package_price', 10, 2)->nullable()->default(0)->after('admin_fee_type');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('patient_plan_subscriptions', 'package_appointments')) {
                        $table->integer('package_appointments')->nullable()->default(1)->after('package_price');
                    }
                });
            }
        } catch (\Throwable $e) {
            // Silently ignore schema exception if running offline
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function () {
            self::ensureSchema();
        });

        static::saving(function () {
            self::ensureSchema();
        });
    }

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

    // Doctor Relation
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
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