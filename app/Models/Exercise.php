<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';

    protected $fillable = [
        'name',
        'description',
        'image',
        'video_url',
        'category',
        'specialization_id',
        'sets_default',
        'reps_default',
        'duration_default',
        'status',
    ];

    public function specialization()
    {
        return $this->belongsTo(Specializations::class, 'specialization_id');
    }

    public function assessmentExercises()
    {
        return $this->hasMany(AssessmentExercise::class, 'exercise_id');
    }

    /**
     * Get full image URL with category fallback
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'http') ? $this->image : asset($this->image);
        }

        $category = strtolower($this->category ?? 'general');
        $fallback = "assets/img/exercises/{$category}.svg";
        if (file_exists(public_path($fallback))) {
            return url($fallback);
        }

        return url('assets/img/exercises/general.svg');
    }
}
