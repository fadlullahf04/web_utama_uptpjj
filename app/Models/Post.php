<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
        'excerpt',
        'content',
        'featured_image',
        'views_count',
        'is_featured',
        'is_published',
        'published_at',
        'tags',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title).'-'.Str::random(5);
            }
            if (empty($post->published_at) && $post->is_published) {
                $post->published_at = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now())->orderBy('published_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->published()->where('is_featured', true);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return str_starts_with($this->featured_image, 'http') ? $this->featured_image : asset('storage/'.$this->featured_image);
        }

        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop';
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));

        return max(1, ceil($words / 200));
    }

    public function getCleanContentAttribute(): string
    {
        $content = $this->content ?? '';

        // Strip dangerous tags completely
        $content = preg_replace('/<(script|style|object|embed|applet)[^>]*>.*?<\/\\1>/is', '', $content) ?? '';
        $content = preg_replace('/<(meta|link|base|frame|frameset)[^>]*>/is', '', $content) ?? '';

        // Strip inline event attributes like onclick, onload, onerror, onmouseover, etc.
        $content = preg_replace('/(\s+)on[a-z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $content) ?? '';

        // Neutralize javascript: or unsafe data: schemes in href and src
        $content = preg_replace_callback('/(href|src)\s*=\s*(["\'])(.*?)\2/i', function ($matches) {
            $attr = strtolower($matches[1]);
            $val = trim($matches[3]);
            if (preg_match('/^javascript:/i', $val)) {
                return "{$attr}=\"#\"";
            }
            if ($attr === 'href' && preg_match('/^data:/i', $val)) {
                return "{$attr}=\"#\"";
            }

            return "{$matches[1]}=\"{$matches[3]}\"";
        }, $content) ?? '';

        return $content;
    }
}
