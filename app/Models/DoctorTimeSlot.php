<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTimeSlot extends Model
{
    protected $table = 'doctor_time_slots';

    protected $fillable = [
        'user_id',
        'availability_date_id',
        'start_time',
        'end_time',
        'is_booked',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'is_booked' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Slot belongs to User (Doctor)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Slot belongs to Availability Date
     */
    public function availabilityDate()
    {
        return $this->belongsTo(DoctorAvailabilityDate::class, 'availability_date_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'time_slot_id');
    }
}