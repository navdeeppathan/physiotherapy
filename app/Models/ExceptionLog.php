<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExceptionLog extends Model
{
    protected $table = 'exception_logs';

    public $timestamps = false; // because we only use created_at

    protected $fillable = [
        'user_id',
        'error_message',
        'error_file',
        'error_line',
        'error_trace',
        'request_url',
        'request_method',
        'ip_address',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}