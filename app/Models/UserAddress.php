<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'is_default',
    ];

    protected $casts = [
        'latitude'   => 'float',
        'longitude'  => 'float',
        'is_default' => 'boolean',
    ];

    /**
     * Address belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}