<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'dob',
        'gender',
        'profile_img',
        'email_verified_at',
        'remember_token',
        'api_token',
        'is_active',
        'is_blocked',
        'otp',
        'otp_expires_at',
        'address',
        'city',
        'state',
        'pincode',
        'latitude',
        'longitude',
        'default_available_days',
        'default_start_time',
        'default_end_time'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function documents()
    {
        return $this->hasMany(DoctorDocument::class, 'user_id');
    }
    public function availabilityDates()
    {
        return $this->hasMany(DoctorAvailabilityDate::class, 'user_id');
    }

    // Doctor appointments
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    // Patient appointments
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    // Reviews received by doctor
    public function receivedReviews()
    {
        return $this->hasMany(DoctorReview::class, 'doctor_id');
    }

    // Reviews given by patient
    public function givenReviews()
    {
        return $this->hasMany(DoctorReview::class, 'patient_id');
    }

    public function fee()
    {
        return $this->hasOne(AppointmentFee::class, 'doctor_id');
    }
}