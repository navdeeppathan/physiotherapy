<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status'
    ];

    // 🔗 علاقة مع Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // 🔗 علاقة مع User (optional if you have User model)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}