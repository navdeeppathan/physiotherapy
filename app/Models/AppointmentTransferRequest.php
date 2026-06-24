<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentTransferRequest extends Model
{
    protected $fillable = [
        'appointment_id',
        'current_doctor_id',
        'requested_doctor_id',
        'reason',
        'status',
        'admin_id',
        'admin_remark',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function currentDoctor()
    {
        return $this->belongsTo(User::class, 'current_doctor_id');
    }

    public function requestedDoctor()
    {
        return $this->belongsTo(User::class, 'requested_doctor_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function transfer()
    {
        return $this->hasOne(
            AppointmentTransfer::class,
            'transfer_request_id'
        );
    }
}