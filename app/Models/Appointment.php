<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'patient_name',
        'patient_age',

        'patient_gender',

        'problem_description',

        'booking_for',
        'time_slot_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'payment_status',
        'is_rescheduled',
        'is_transferred' 
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Doctor (User with role doctor)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Patient (User with role patient)
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Related Time Slot
     */
    public function timeSlot()
    {
        return $this->belongsTo(DoctorTimeSlot::class, 'time_slot_id');
    }

    public function review()
    {
        return $this->hasOne(DoctorReview::class, 'appointment_id');
    }

    public function reschedules()
    {
        return $this->hasMany(AppointmentReschedule::class);
    }

    public function cancellation()
    {
        return $this->hasOne(AppointmentCancellation::class, 'appointment_id', 'id')
                    ->with('reason');
    }

    public function transferRequest()
    {
        return $this->hasOne(
            AppointmentTransferRequest::class,
            'appointment_id'
        );
    }

    public function transfers()
    {
        return $this->hasMany(
            AppointmentTransfer::class,
            'appointment_id'
        );
    }
    
}