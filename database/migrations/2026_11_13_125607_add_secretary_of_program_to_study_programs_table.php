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
        Schema::table('study_programs', function (Blueprint $table) {
            $table->string('secretary_of_program')->nullable()->after('head_of_program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropColumn('secretary_of_program');
        });
    }
};
