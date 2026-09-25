<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'attachment_file',
        'attachment_name',
        'is_pinned',
        'is_published',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title) . '-' . Str::random(5);
            }
            if (empty($item->published_at) && $item->is_published) {
                $item->published_at = now();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc');
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        if (!$this->attachment_file) return null;
        return str_starts_with($this->attachment_file, 'http') ? $this->attachment_file : asset('storage/' . $this->attachment_file);
    }
}
