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
        'status'
    ];

    public $timestamps = true;
}