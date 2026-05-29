<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentReschedule extends Model
{
    protected $fillable = [
        'appointment_id',
        'old_date',
        'old_start_time',
        'old_end_time',
        'new_date',
        'new_start_time',
        'new_end_time',
        'rescheduled_by',
        'reason'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}