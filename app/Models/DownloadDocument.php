<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DownloadDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'external_url',
        'file_type',
        'file_size',
        'downloads_count',
        'order',
        'is_active',
    ];

    protected $casts = [
        'downloads_count' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title).'-'.Str::random(4);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    public function getDownloadUrlAttribute(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }
        if ($this->file_path) {
            return str_starts_with($this->file_path, 'http') ? $this->file_path : asset('storage/'.$this->file_path);
        }

        return '#';
    }
}
