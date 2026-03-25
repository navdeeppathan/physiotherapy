<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentCancellation extends Model
{
    protected $table = 'appointment_cancellations';

    protected $fillable = [
        'user_id',
        'appointment_id',
        'reason_id',
        'custom_reason',
        'cancelled_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * User who performed cancellation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Related Appointment
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    /**
     * Cancellation Reason
     */
    public function reason()
    {
        return $this->belongsTo(CancellationReason::class, 'reason_id');
    }
}