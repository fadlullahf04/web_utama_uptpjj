<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class OrganizationCategory extends Model
{
    public const TIER_KEPALA = 1;

    public const TIER_SEKRETARIS = 2;

    public const TIER_PIMPINAN_JURUSAN = 3;

    public const TIER_STAFF = 4;

    public const TIER_LABELS = [
        self::TIER_KEPALA => 'Kepala UPT PJJ',
        self::TIER_SEKRETARIS => 'Sekretaris UPT PJJ',
        self::TIER_PIMPINAN_JURUSAN => 'Pimpinan Jurusan',
        self::TIER_STAFF => 'Staff UPT PJJ',
    ];

    protected $fillable = [
        'name',
        'tier',
        'order',
    ];

    protected $casts = [
        'tier' => 'integer',
        'order' => 'integer',
    ];

    public static function seedDefaultsIfEmpty(): void
    {
        if (! Schema::hasTable('organization_categories')) {
            return;
        }

        if (static::count() > 0) {
            return;
        }

        $defaults = [
            ['name' => 'Kepala UPT PJJ', 'tier' => self::TIER_KEPALA, 'order' => 1],
            ['name' => 'Sekretaris UPT PJJ', 'tier' => self::TIER_SEKRETARIS, 'order' => 2],
            ['name' => 'Ketua Jurusan', 'tier' => self::TIER_PIMPINAN_JURUSAN, 'order' => 3],
            ['name' => 'Sekretaris Jurusan', 'tier' => self::TIER_PIMPINAN_JURUSAN, 'order' => 4],
            ['name' => 'Staff UPT PJJ', 'tier' => self::TIER_STAFF, 'order' => 5],
        ];

        foreach ($defaults as $item) {
            static::firstOrCreate(['name' => $item['name']], $item);
        }
    }

    public static function allOrdered(): Collection
    {
        if (! Schema::hasTable('organization_categories')) {
            return collect([
                (object) ['id' => 1, 'name' => 'Kepala UPT PJJ', 'tier' => self::TIER_KEPALA, 'order' => 1],
                (object) ['id' => 2, 'name' => 'Sekretaris UPT PJJ', 'tier' => self::TIER_SEKRETARIS, 'order' => 2],
                (object) ['id' => 3, 'name' => 'Ketua Jurusan', 'tier' => self::TIER_PIMPINAN_JURUSAN, 'order' => 3],
                (object) ['id' => 4, 'name' => 'Sekretaris Jurusan', 'tier' => self::TIER_PIMPINAN_JURUSAN, 'order' => 4],
                (object) ['id' => 5, 'name' => 'Staff UPT PJJ', 'tier' => self::TIER_STAFF, 'order' => 5],
            ]);
        }

        static::seedDefaultsIfEmpty();

        return static::orderBy('tier', 'asc')->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
    }

    public function getTierLabelAttribute(): string
    {
        return self::TIER_LABELS[$this->tier] ?? 'Staff UPT PJJ';
    }
}
