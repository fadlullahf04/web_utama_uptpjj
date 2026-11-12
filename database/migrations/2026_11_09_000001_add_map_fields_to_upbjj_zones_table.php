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
            $table->integer('students_count')->default(0)->after('address');
            $table->string('bubble_color', 30)->default('emerald')->after('students_count');
            $table->decimal('map_x', 5, 2)->nullable()->after('bubble_color');
            $table->decimal('map_y', 5, 2)->nullable()->after('map_x');
        });

        // Populate default student counts, bubble colors, and Indonesia map coordinates for existing zones
        $presets = [
            'ZONA 01' => ['students_count' => 3420, 'bubble_color' => 'emerald', 'map_x' => 30.5, 'map_y' => 70.0],
            'ZONA 02' => ['students_count' => 2150, 'bubble_color' => 'teal', 'map_x' => 39.5, 'map_y' => 73.5],
            'ZONA 03' => ['students_count' => 1180, 'bubble_color' => 'amber', 'map_x' => 17.5, 'map_y' => 45.0],
            'ZONA 04' => ['students_count' => 690, 'bubble_color' => 'blue', 'map_x' => 43.0, 'map_y' => 44.0],
            'ZONA 05' => ['students_count' => 540, 'bubble_color' => 'purple', 'map_x' => 58.5, 'map_y' => 49.0],
            'ZONA 06' => ['students_count' => 410, 'bubble_color' => 'rose', 'map_x' => 82.0, 'map_y' => 57.0],
            'ZONA LN' => ['students_count' => 160, 'bubble_color' => 'cyan', 'map_x' => 24.0, 'map_y' => 18.0],
        ];

        foreach ($presets as $code => $data) {
            DB::table('upbjj_zones')->where('code', $code)->update($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upbjj_zones', function (Blueprint $table) {
            $table->dropColumn(['students_count', 'bubble_color', 'map_x', 'map_y']);
        });
    }
};

