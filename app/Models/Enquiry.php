<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $table = 'enquiries';

    protected $fillable = [
        'user_id',
        'patient_name',
        'symptoms',
        'location',
        'contact_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * User relation if submitted by logged in patient
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
