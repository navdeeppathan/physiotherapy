<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class HeroBanner extends Model
{
    use HasFactory;

    protected $table = 'hero_banners';

    protected $fillable = [
        'title',
        'time',
        'description',
        'image',
        'button_text',
        'button_link',
        'button_text_2',
        'button_link_2',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Scope active banners sorted by order and creation
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('order', 'asc')->orderBy('id', 'desc');
    }

    /**
     * Get the full URL for the banner image
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('assets/img/hero/hero-1.jpg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (file_exists(public_path('images/banners/' . $this->image))) {
            return asset('images/banners/' . $this->image);
        }

        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return asset('images/banners/' . $this->image);
    }

    /**
     * Self-healing table check: ensure table exists even before migration is manually executed.
     */
    public static function ensureTableExists()
    {
        try {
            if (!Schema::hasTable('hero_banners')) {
                Schema::create('hero_banners', function (Blueprint $table) {
                    $table->id();
                    $table->string('title')->nullable();
                    $table->string('time')->nullable()->comment('Time / badge / subtitle, e.g. 24/7 Available or 7 AM - 9 PM');
                    $table->text('description')->nullable();
                    $table->string('image')->nullable();
                    $table->string('button_text')->nullable()->default('Book Appointment');
                    $table->string('button_link')->nullable()->default('#search-bar');
                    $table->string('button_text_2')->nullable()->default('Find Physiotherapist');
                    $table->string('button_link_2')->nullable()->default('#specialists');
                    $table->integer('order')->default(0);
                    $table->enum('status', ['active', 'inactive'])->default('active');
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Silently catch if DB permissions or connection is restricted
            \Illuminate\Support\Facades\Log::warning('hero_banners table ensure error: ' . $e->getMessage());
        }
    }
}
