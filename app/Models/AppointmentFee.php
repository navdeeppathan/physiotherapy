<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentFee extends Model
{
    protected $table = 'appointment_fees';

    protected $fillable = [
        'doctor_id',
        'doctor_fee',
        'admin_fee',
        'admin_fee_type',
        'total_fee'
    ];

    /**
     * 🔗 Relation with Doctor (User)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Self-healing: Ensure admin_fee_type column exists
     */
    public static function ensureSchema(): void
    {
        static $checked = false;
        if ($checked) return;
        $checked = true;

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('appointment_fees')) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('appointment_fees', 'admin_fee_type')) {
                    \Illuminate\Support\Facades\Schema::table('appointment_fees', function (\Illuminate\Database\Schema\Blueprint $table) {
                        $table->string('admin_fee_type', 20)->default('fixed')->after('admin_fee');
                    });
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore schema exception if running offline
        }
    }

    /**
     * Calculate effective admin fee amount per appointment (Fixed or Percentage)
     */
    public function getAdminFeeAmount(): float
    {
        $df = (float) ($this->doctor_fee ?? 0);
        $af = (float) ($this->admin_fee ?? 0);
        $type = strtolower((string) ($this->admin_fee_type ?? 'fixed'));

        if ($type === 'percentage') {
            return round(($df * $af) / 100, 2);
        }

        return round($af, 2);
    }

    /**
     * Combined per-appointment fee = Doctor Fee + Admin Fee
     */
    public function getPerAppointmentTotal(): float
    {
        $df = (float) ($this->doctor_fee ?? 0);
        return round($df + $this->getAdminFeeAmount(), 2);
    }

    /**
     * Calculate package price = (Doctor Fee + Admin Fee) * Package Appointments
     */
    public function getPackagePrice(int $appointmentsCount = 1): float
    {
        return round($this->getPerAppointmentTotal() * max(1, $appointmentsCount), 2);
    }

    /**
     * 🔥 Auto-calculate total before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function () {
            self::ensureSchema();
        });

        static::saving(function ($model) {
            self::ensureSchema();
            $df = (float) ($model->doctor_fee ?? 0);
            $af = (float) ($model->admin_fee ?? 0);
            $type = strtolower((string) ($model->admin_fee_type ?? 'fixed'));
            $calculatedAdminFee = ($type === 'percentage') ? round(($df * $af) / 100, 2) : $af;
            $model->total_fee = round($df + $calculatedAdminFee, 2);
        });
    }
}