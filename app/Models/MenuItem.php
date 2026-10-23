<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'parent_id',
        'title',
        'type',
        'page_id',
        'route_name',
        'url',
        'target',
        'icon',
        'badge',
        'badge_color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function activeChildren(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order', 'asc');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function getUrl(): string
    {
        if ($this->type === 'page') {
            return $this->page ? route('pages.show', $this->page->slug) : '#';
        }

        if ($this->type === 'route' && ! empty($this->route_name)) {
            return Route::has($this->route_name) ? route($this->route_name) : '#';
        }

        return $this->url ?? '#';
    }

    public function isActiveRoute(): bool
    {
        if ($this->type === 'page' && $this->page) {
            return request()->is('halaman/'.$this->page->slug) || request()->is($this->page->slug);
        }

        if ($this->type === 'route' && ! empty($this->route_name)) {
            if ($this->route_name === 'home') {
                return request()->routeIs('home');
            }

            $prefix = explode('.', $this->route_name)[0];

            return request()->routeIs($this->route_name) || request()->routeIs($prefix.'.*');
        }

        if ($this->type === 'custom' && ! empty($this->url)) {
            $currentUrl = request()->url();
            $targetUrl = url($this->url);

            return $currentUrl === $targetUrl;
        }

        return false;
    }

    /**
     * Get hierarchically organized menu tree for a location.
     *
     * @return Collection<int, MenuItem>
     */
    public static function getTree(string $location = 'header'): Collection
    {
        return static::location($location)
            ->topLevel()
            ->active()
            ->orderBy('order', 'asc')
            ->with(['page', 'activeChildren' => function ($query) {
                $query->with('page')->orderBy('order', 'asc');
            }])
            ->get();
    }

    /**
     * Get list of system routes available for menu linking.
     *
     * @return array<string, string>
     */
    public static function getAvailableRoutes(): array
    {
        return [
            'home' => 'Beranda (Home)',
            'profile.overview' => 'Profil - Selayang Pandang',
            'profile.vision-mission' => 'Profil - Visi dan Misi',
            'profile.organization' => 'Profil - Struktur Organisasi',
            'profile.graduate-profile' => 'Profil - Profil Lulusan',
            'profile.team' => 'Profil - Tim UPT PJJ',
            'profile.video-profile' => 'Profil - Video Profile',
            'profile.facilities' => 'Profil - Sarana & Prasarana',
            'programs.index' => 'Program Studi PJJ (Semua)',
            'services.index' => 'Layanan & Fasilitas PJJ',
            'announcements.index' => 'Pengumuman Resmi',
            'posts.index' => 'Berita & Artikel Kampus',
            'faqs' => 'Tanya Jawab (FAQs)',
            'lms-guide' => 'Course & Panduan LMS Pillar',
            'downloads.index' => 'Unduhan Dokumen & Panduan',
            'contact.index' => 'Kontak & Layanan Helpdesk',
        ];
    }
}
