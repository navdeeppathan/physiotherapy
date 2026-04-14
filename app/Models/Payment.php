<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Payment belongs to Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Payment belongs to Patient (User)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Payment belongs to Doctor (User)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}