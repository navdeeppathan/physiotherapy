<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specializations extends Model
{
    use HasFactory;

    protected $table = 'specializations'; // change if your table name is different

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'status',
        'icon'
    ];

    public $timestamps = true;

    public function doctorProfiles()
    {
        return $this->hasMany(DoctorProfile::class, 'specialization', 'id');
    }

    public function doctors()
    {
        return $this->hasManyThrough(User::class, DoctorProfile::class, 'specialization', 'id', 'id', 'user_id')
            ->where('users.role', 'doctor')
            ->where('users.status', 'active');
    }
}