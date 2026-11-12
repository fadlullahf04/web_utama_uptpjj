<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('upbjj_zones', function (Blueprint $table) {
            $table->integer('male_students_count')->default(0)->after('address');
            $table->integer('female_students_count')->default(0)->after('male_students_count');
        });

        // Populate default male & female student counts for existing zones
        $presets = [
            'ZONA 01' => ['male_students_count' => 1580, 'female_students_count' => 1840, 'students_count' => 3420],
            'ZONA 02' => ['male_students_count' => 990, 'female_students_count' => 1160, 'students_count' => 2150],
            'ZONA 03' => ['male_students_count' => 540, 'female_students_count' => 640, 'students_count' => 1180],
            'ZONA 04' => ['male_students_count' => 320, 'female_students_count' => 370, 'students_count' => 690],
            'ZONA 05' => ['male_students_count' => 250, 'female_students_count' => 290, 'students_count' => 540],
            'ZONA 06' => ['male_students_count' => 195, 'female_students_count' => 215, 'students_count' => 410],
            'ZONA LN' => ['male_students_count' => 75, 'female_students_count' => 85, 'students_count' => 160],
        ];

        foreach ($presets as $code => $data) {
            DB::table('upbjj_zones')->where('code', $code)->update($data);
        }

        // For any custom zone where male/female is still 0 but students_count > 0
        $others = DB::table('upbjj_zones')
            ->where('male_students_count', 0)
            ->where('female_students_count', 0)
            ->where('students_count', '>', 0)
            ->get();

        foreach ($others as $zone) {
            $male = (int) floor($zone->students_count * 0.46);
            $female = (int) ($zone->students_count - $male);
            DB::table('upbjj_zones')->where('id', $zone->id)->update([
                'male_students_count' => $male,
                'female_students_count' => $female,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upbjj_zones', function (Blueprint $table) {
            $table->dropColumn(['male_students_count', 'female_students_count']);
        });
    }
};

