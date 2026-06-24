<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentTransferRequest extends Model
{
    protected $fillable = [
        'doctor_id',
        'from_date',
        'to_date',
        'reason',
        'status',
        'admin_id',
        'admin_remark',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function transfers()
    {
        return $this->hasMany(AppointmentTransfer::class, 'transfer_request_id');
    }
}