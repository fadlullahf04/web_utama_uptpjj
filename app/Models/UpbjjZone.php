<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpbjjZone extends Model
{
    protected $fillable = [
        'code',
        'name',
        'coverage',
        'partner',
        'head_name',
        'vice_head_name',
        'secretary_name',
        'coordinator_name',
        'phone',
        'address',
        'male_students_count',
        'female_students_count',
        'students_count',
        'bubble_color',
        'map_x',
        'map_y',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'male_students_count' => 'integer',
        'female_students_count' => 'integer',
        'students_count' => 'integer',
        'map_x' => 'float',
        'map_y' => 'float',
    ];

    /**
     * Seed default 7 UPBJJ zones if the table is empty.
     */
    public static function seedDefaultsIfEmpty(): void
    {
        if (static::count() > 0) {
            return;
        }

        $defaults = [
            [
                'code' => 'ZONA 01',
                'name' => 'UPBJJ Wilayah Jawa Barat, DKI Jakarta & Banten (Pusat Cirebon)',
                'coverage' => 'Cirebon, Indramayu, Majalengka, Kuningan, Bandung, Bogor, Bekasi, Tangerang, Serang, DKI Jakarta',
                'partner' => 'Kampus Pusat Gedung Siber UINSSC & Kanwil Kemenag Jabar/DKI/Banten',
                'coordinator_name' => 'Sekretariat Pusat UPT PJJ UINSSC',
                'phone' => '+62 811-2345-678',
                'address' => 'Gedung Siber Lt. 3, Kampus UIN Siber Syekh Nurjati Cirebon',
                'male_students_count' => 1580,
                'female_students_count' => 1840,
                'students_count' => 3420,
                'bubble_color' => 'emerald',
                'map_x' => 30.5,
                'map_y' => 70.0,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA 02',
                'name' => 'UPBJJ Wilayah Jawa Tengah, DI Yogyakarta & Jawa Timur',
                'coverage' => 'Semarang, Brebes, Tegal, Banyumas, Surakarta, Yogyakarta, Surabaya, Malang, Jember, Madura',
                'partner' => 'Jaringan Kemenag Kab/Kota, Madrasah & Pesantren Mitra',
                'coordinator_name' => 'Koordinator Wilayah Jawa Tengah & Timur',
                'phone' => '+62 811-2345-678',
                'address' => 'Sentra Layanan Mitra Kemenag Wilayah Jateng, DIY & Jatim',
                'male_students_count' => 990,
                'female_students_count' => 1160,
                'students_count' => 2150,
                'bubble_color' => 'teal',
                'map_x' => 39.5,
                'map_y' => 73.5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA 03',
                'name' => 'UPBJJ Wilayah Sumatera',
                'coverage' => 'Banda Aceh, Medan, Padang, Pekanbaru, Batam, Jambi, Palembang, Bengkulu, Bandar Lampung, Pangkalpinang',
                'partner' => 'Sentra Layanan Daerah & Pokjar Guru Madrasah Sumatera',
                'coordinator_name' => 'Koordinator Wilayah Sumatera',
                'phone' => '+62 811-2345-678',
                'address' => 'Sentra Layanan Mitra Kemenag Wilayah Sumatera',
                'male_students_count' => 540,
                'female_students_count' => 640,
                'students_count' => 1180,
                'bubble_color' => 'amber',
                'map_x' => 17.5,
                'map_y' => 45.0,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA 04',
                'name' => 'UPBJJ Wilayah Kalimantan',
                'coverage' => 'Pontianak, Palangkaraya, Banjarmasin, Samarinda, Balikpapan, Ibu Kota Nusantara (IKN), Tarakan',
                'partner' => 'Sentra Layanan Daerah & Pokjar Kemenag Kalimantan',
                'coordinator_name' => 'Koordinator Wilayah Kalimantan',
                'phone' => '+62 811-2345-678',
                'address' => 'Sentra Layanan Mitra Kemenag Wilayah Kalimantan',
                'male_students_count' => 320,
                'female_students_count' => 370,
                'students_count' => 690,
                'bubble_color' => 'blue',
                'map_x' => 43.0,
                'map_y' => 44.0,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA 05',
                'name' => 'UPBJJ Wilayah Sulawesi',
                'coverage' => 'Makassar, Parepare, Palu, Kendari, Mamuju, Gorontalo, Manado',
                'partner' => 'Sentra Layanan Daerah & Pokjar Madrasah Sulawesi',
                'coordinator_name' => 'Koordinator Wilayah Sulawesi',
                'phone' => '+62 811-2345-678',
                'address' => 'Sentra Layanan Mitra Kemenag Wilayah Sulawesi',
                'male_students_count' => 250,
                'female_students_count' => 290,
                'students_count' => 540,
                'bubble_color' => 'purple',
                'map_x' => 58.5,
                'map_y' => 49.0,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA 06',
                'name' => 'UPBJJ Wilayah Bali, Nusa Tenggara, Maluku & Papua',
                'coverage' => 'Denpasar, Mataram, Kupang, Ambon, Ternate, Sorong, Manokwari, Jayapura, Merauke',
                'partner' => 'Sentra Layanan Afirmasi 3T & Kemitraan Kemenag Timur',
                'coordinator_name' => 'Koordinator Wilayah Indonesia Timur',
                'phone' => '+62 811-2345-678',
                'address' => 'Sentra Layanan Afirmasi Wilayah Bali, Nusra, Maluku & Papua',
                'male_students_count' => 195,
                'female_students_count' => 215,
                'students_count' => 410,
                'bubble_color' => 'rose',
                'map_x' => 82.0,
                'map_y' => 57.0,
                'order' => 6,
                'is_active' => true,
            ],
            [
                'code' => 'ZONA LN',
                'name' => 'Unit Layanan Mahasiswa Luar Negeri (Overseas)',
                'coverage' => 'Malaysia, Singapura, Brunei Darussalam, Arab Saudi, Mesir, Taiwan, Hongkong, Jepang, Korea Selatan',
                'partner' => 'Pusat Layanan Internasional UINSSC & Komunitas Pekerja/Mahasiswa RI',
                'coordinator_name' => 'Divisi Kerjasama Internasional UPT PJJ',
                'phone' => '+62 811-2345-678',
                'address' => 'Layanan Daring Internasional Terpusat UINSSC Cirebon',
                'male_students_count' => 75,
                'female_students_count' => 85,
                'students_count' => 160,
                'bubble_color' => 'cyan',
                'map_x' => 24.0,
                'map_y' => 18.0,
                'order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($defaults as $zone) {
            static::create($zone);
        }
    }

    /**
     * Render the interactive Indonesia Bubble Map and proportional HTML directory table for the UPBJJ page.
     */
    public static function renderHtmlTable(): string
    {
        static::seedDefaultsIfEmpty();

        $zones = static::where('is_active', true)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $galleries = UpbjjGallery::with('zone')->orderBy('order', 'asc')->orderByDesc('id')->get();

        $mapHtml = view('partials.upbjj-map', compact('zones'))->render();
        $galleryHtml = view('partials.upbjj-gallery', compact('galleries'))->render();

        $dotColors = [
            'emerald' => 'bg-emerald-500',
            'teal' => 'bg-teal-500',
            'amber' => 'bg-amber-500',
            'blue' => 'bg-blue-500',
            'purple' => 'bg-purple-500',
            'rose' => 'bg-rose-500',
            'cyan' => 'bg-cyan-500',
        ];

        $totalMale = (int) $zones->sum('male_students_count');
        $totalFemale = (int) $zones->sum('female_students_count');
        $totalAll = (int) $zones->sum('students_count');

        $rows = '';
        foreach ($zones as $index => $zone) {
            $rowBg = $index % 2 === 1 ? ' class="bg-slate-50/60"' : '';
            $codeColor = str_contains(strtoupper($zone->code), 'LN') ? 'text-amber-700' : 'text-[#006837]';
            $dotClass = $dotColors[$zone->bubble_color] ?? 'bg-emerald-500';

            $detailsHtml = '<div class="mt-1.5 space-y-1 text-[11px] text-slate-600">'
                .'<div><span class="font-bold text-slate-700">Cakupan:</span> '.e($zone->coverage).'</div>';

            if ($zone->partner) {
                $detailsHtml .= '<div><span class="font-bold text-slate-700">Mitra:</span> '.e($zone->partner).'</div>';
            }

            if ($zone->head_name || $zone->vice_head_name || $zone->secretary_name) {
                $leadershipParts = array_filter([
                    $zone->head_name ? '<span class="font-bold text-slate-700">Ketua:</span> '.e($zone->head_name) : null,
                    $zone->vice_head_name ? '<span class="font-bold text-slate-700">Wakil Ketua:</span> '.e($zone->vice_head_name) : null,
                    $zone->secretary_name ? '<span class="font-bold text-slate-700">Sekretaris:</span> '.e($zone->secretary_name) : null,
                ]);
                if (! empty($leadershipParts)) {
                    $detailsHtml .= '<div class="pt-1 flex flex-wrap gap-x-4 gap-y-1 text-slate-600"><span>'.implode('</span><span>', $leadershipParts).'</span></div>';
                }
            }

            if ($zone->coordinator_name || $zone->phone || $zone->address) {
                $parts = array_filter([
                    $zone->coordinator_name ? '<i class="fa-solid fa-user-tie text-[#006837] mr-1"></i>'.e($zone->coordinator_name) : null,
                    $zone->phone ? '<i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i>'.e($zone->phone) : null,
                ]);
                if (! empty($parts)) {
                    $detailsHtml .= '<div class="pt-1 text-slate-500 flex flex-wrap gap-x-3 gap-y-1"><span>'.implode('</span><span>', $parts).'</span></div>';
                }
            }
            $detailsHtml .= '</div>';

            $rows .= '<tr'.$rowBg.'>'
                .'<td class="p-3.5 border border-slate-300 font-extrabold '.$codeColor.' whitespace-nowrap align-top w-28">'
                .'<span class="inline-flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full '.$dotClass.' shrink-0"></span>'.e($zone->code).'</span>'
                .'</td>'
                .'<td class="p-3.5 border border-slate-300 align-top">'
                .'<div class="font-bold text-slate-900 text-xs sm:text-sm leading-snug">'.e($zone->name).'</div>'
                .$detailsHtml
                .'</td>'
                .'<td class="p-3.5 border border-slate-300 align-middle text-center font-bold text-sky-700 whitespace-nowrap w-24">'.number_format((int) $zone->male_students_count, 0, ',', '.').'</td>'
                .'<td class="p-3.5 border border-slate-300 align-middle text-center font-bold text-pink-700 whitespace-nowrap w-24">'.number_format((int) $zone->female_students_count, 0, ',', '.').'</td>'
                .'<td class="p-3.5 border border-slate-300 align-middle text-center font-extrabold text-[#006837] bg-emerald-50/50 whitespace-nowrap w-28">'.number_format((int) $zone->students_count, 0, ',', '.').'</td>'
                .'</tr>';
        }

        if ($rows === '') {
            $rows = '<tr><td colspan="5" class="p-4 text-center text-slate-400">Belum ada data zona wilayah layanan UPBJJ.</td></tr>';
        }

        $tfoot = '<tfoot>'
            .'<tr class="bg-emerald-900 text-white font-extrabold">'
            .'<td colspan="2" class="p-3.5 border border-emerald-800 text-right uppercase tracking-wider text-[11px]">'
            .'Total Keseluruhan Mahasiswa ('.$zones->count().' Zona Wilayah)'
            .'</td>'
            .'<td class="p-3.5 border border-emerald-800 text-center text-sky-200 whitespace-nowrap">'.number_format($totalMale, 0, ',', '.').'</td>'
            .'<td class="p-3.5 border border-emerald-800 text-center text-pink-200 whitespace-nowrap">'.number_format($totalFemale, 0, ',', '.').'</td>'
            .'<td class="p-3.5 border border-emerald-800 text-center text-amber-300 text-sm whitespace-nowrap">'.number_format($totalAll, 0, ',', '.').' Mhs</td>'
            .'</tr>'
            .'</tfoot>';

        return '<div class="upbjj-dynamic-directory">'
            .$mapHtml
            .'<div class="overflow-x-auto my-6 rounded-2xl border border-slate-300 shadow-xs">'
            .'<table class="w-full text-left border-collapse text-xs">'
            .'<thead>'
            .'<tr class="bg-emerald-50 text-emerald-950 font-extrabold">'
            .'<th class="p-3.5 border border-slate-300 whitespace-nowrap">Kode Zona</th>'
            .'<th class="p-3.5 border border-slate-300">Wilayah Layanan, Cakupan Pokjar & Mitra</th>'
            .'<th class="p-3.5 border border-slate-300 text-center whitespace-nowrap">Laki-Laki (L)</th>'
            .'<th class="p-3.5 border border-slate-300 text-center whitespace-nowrap">Perempuan (P)</th>'
            .'<th class="p-3.5 border border-slate-300 text-center whitespace-nowrap">Total Mhs</th>'
            .'</tr>'
            .'</thead>'
            .'<tbody>'.$rows.'</tbody>'
            .$tfoot
            .'</table>'
            .'</div>'
            .$galleryHtml
            .'</div>';
    }
}
