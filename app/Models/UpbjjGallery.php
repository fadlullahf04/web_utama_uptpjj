<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpbjjGallery extends Model
{
    protected $fillable = [
        'upbjj_zone_id',
        'title',
        'image',
        'activity_date',
        'description',
        'order',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'order' => 'integer',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(UpbjjZone::class, 'upbjj_zone_id');
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=800&auto=format&fit=crop';
        }

        return str_starts_with($this->image, 'http') ? $this->image : asset('storage/'.$this->image);
    }
}
