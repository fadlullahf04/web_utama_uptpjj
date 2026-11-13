<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('upbjj_zones', function (Blueprint $table) {
            $table->string('head_name')->nullable()->after('partner');
            $table->string('vice_head_name')->nullable()->after('head_name');
            $table->string('secretary_name')->nullable()->after('vice_head_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upbjj_zones', function (Blueprint $table) {
            $table->dropColumn(['head_name', 'vice_head_name', 'secretary_name']);
        });
    }
};
