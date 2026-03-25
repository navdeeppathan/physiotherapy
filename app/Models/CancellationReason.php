<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{
    protected $table = 'cancellation_reasons';

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Cancellation Reason used in Appointments
     * (Only if you add cancellation_reason_id in appointments table)
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'cancellation_reason_id');
    }
}