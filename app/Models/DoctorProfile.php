<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $table = 'doctor_profiles';

    protected $fillable = [
        'user_id',
        'specialization',
        'experience_years',
        'consultation_fee',
        'clinic_address',
        'bio',
        'career_path',
        'highlights',
        'qualification',
        'clinic_name',
        'experience_level',
        'city',
        'state',
        'pincode',
        'latitude',
        'longitude',
        'home_visit_available',
        'clinic_visit_available',
        'rating',
        'total_reviews',
        'approval_status',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'consultation_fee' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: DoctorProfile belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}