<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'degree',
        'faculty',
        'accreditation',
        'code',
        'head_of_program',
        'head_nip',
        'graduate_title',
        'short_description',
        'description',
        'vision_mission',
        'curriculum',
        'career_prospects',
        'total_credits',
        'study_duration',
        'learning_method',
        'tuition_info',
        'image',
        'brochure_file',
        'registration_url',
        'website_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'total_credits' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'http') ? $this->image : asset('storage/'.$this->image);
        }

        return 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop';
    }
}
