<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailabilityDate extends Model
{
    protected $table = 'doctor_availability_dates';

    protected $fillable = [
        'user_id',
        'available_date',
        'is_available',
    ];

    protected $casts = [
        'available_date' => 'date',
        'is_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Availability belongs to User (Doctor)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function timeSlots()
    {
        return $this->hasMany(DoctorTimeSlot::class, 'availability_date_id');
    }
}