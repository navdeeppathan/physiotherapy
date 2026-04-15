<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorWallet extends Model
{
    use HasFactory;

    protected $table = 'doctor_wallets';

    protected $fillable = [
        'doctor_id',
        'balance',
        'currency',
    ];

    /**
     * Relationship: Wallet belongs to a Doctor (User)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

   
   
}