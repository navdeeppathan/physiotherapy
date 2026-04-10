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
     * 🔥 Auto-calculate total before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_fee = $model->doctor_fee + $model->admin_fee;
        });
    }
}