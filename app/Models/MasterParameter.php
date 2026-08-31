<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterParameter extends Model
{
    use HasFactory;

    protected $table = 'master_parameters';

    protected $fillable = [
        'key',
        'label',
        'unit',
        'icon',
        'icon_key',
        'description',
        'sort_order',
        'status',
    ];

    /**
     * Get full icon URL
     */
    public function getIconUrlAttribute(): ?string
    {
        if (!$this->icon) {
            // Fallback to svg in assets/img/parameters/
            $fallback = 'assets/img/parameters/' . ($this->icon_key ?? $this->key) . '.svg';
            if (file_exists(public_path($fallback))) {
                return url($fallback);
            }
            return null;
        }

        if (str_starts_with($this->icon, 'http://') || str_starts_with($this->icon, 'https://')) {
            return $this->icon;
        }

        return url($this->icon);
    }
}
