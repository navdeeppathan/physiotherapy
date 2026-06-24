<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentTransfer extends Model
{
    protected $fillable = [
        'appointment_id',
        'old_doctor_id',
        'new_doctor_id',
        'transfer_request_id',
        'transferred_by',
        'remarks',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function oldDoctor()
    {
        return $this->belongsTo(User::class, 'old_doctor_id');
    }

    public function newDoctor()
    {
        return $this->belongsTo(User::class, 'new_doctor_id');
    }

    public function transferRequest()
    {
        return $this->belongsTo(
            AppointmentTransferRequest::class,
            'transfer_request_id'
        );
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}