<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'category',
        'media_url',
        'thumbnail',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return str_starts_with($this->thumbnail, 'http') ? $this->thumbnail : asset('storage/'.$this->thumbnail);
        }
        if ($this->type === 'image') {
            return str_starts_with($this->media_url, 'http') ? $this->media_url : asset('storage/'.$this->media_url);
        }

        return 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800&auto=format&fit=crop';
    }
}
