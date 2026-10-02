<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\DoctorDocument;
use App\Models\UserAddress;
use App\Models\DoctorAvailabilityDate;
use App\Models\DoctorTimeSlot;
use App\Models\Appointment;
use App\Models\DoctorReview;
use App\Models\AppointmentFee;
use App\Models\DoctorWallet;
use App\Models\DoctorProfile;
use App\Models\Feedback;

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

    /**
     * Always lowercase and trim email before storing
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = !empty($value) ? strtolower(trim((string) $value)) : null;
    }

    /**
     * Always normalize phone numbers to standard format before storing
     */
    public function setPhoneAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['phone'] = null;
            return;
        }

        $this->attributes['phone'] = self::normalizePhone($value);
    }

    /**
     * Standardize email string: lowercase and trimmed
     */
    public static function normalizeEmail($email): string
    {
        return strtolower(trim((string) $email));
    }

    /**
     * Standardize phone string to 10-digit number when possible
     */
    public static function normalizePhone($phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            return substr($digits, 2);
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            return substr($digits, 1);
        }

        return $digits ?: trim((string) $phone);
    }

    /**
     * Get all common variations of a phone number for comprehensive lookup
     */
    public static function getPhoneVariations($phone): array
    {
        $raw = trim((string) $phone);
        $normalized = self::normalizePhone($phone);
        $digits = preg_replace('/\D+/', '', (string) $phone);

        return array_values(array_unique(array_filter([
            $raw,
            $digits,
            $normalized,
            '91' . $normalized,
            '+91' . $normalized,
            '+91 ' . $normalized,
            '0' . $normalized,
        ])));
    }

    /**
     * Find user by case-insensitive trimmed email
     */
    public static function findByEmail($email): ?self
    {
        if (empty($email)) {
            return null;
        }
        $clean = self::normalizeEmail($email);
        return self::whereRaw('LOWER(TRIM(email)) = ?', [$clean])->first();
    }

    /**
     * Find user by any variation of phone number
     */
    public static function findByPhone($phone): ?self
    {
        if (empty($phone)) {
            return null;
        }
        $variations = self::getPhoneVariations($phone);
        return self::whereIn('phone', $variations)->first();
    }

    public function documents()
    {
        return $this->hasMany(DoctorDocument::class, 'user_id');
    }
    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id');
    }

    

    public function availabilityDates()
    {
        return $this->hasMany(DoctorAvailabilityDate::class, 'user_id');
    }
    public function timeSlots()
    {
        return $this->hasMany(
            DoctorTimeSlot::class,
            'user_id'
        );
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

    public function wallet()
    {
        return $this->hasOne(DoctorWallet::class, 'doctor_id');
    }

    public function profile()
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'doctor_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}