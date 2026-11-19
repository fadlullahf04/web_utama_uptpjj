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
        if (! Schema::hasTable('organization_categories')) {
            Schema::create('organization_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->unsignedTinyInteger('tier')->default(4); // 1: Kepala UPT, 2: Sekretaris UPT, 3: Pimpinan Jurusan, 4: Staff UPT
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('team_members') && ! Schema::hasColumn('team_members', 'department')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->string('department')->nullable()->after('division');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('team_members') && Schema::hasColumn('team_members', 'department')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        }

        Schema::dropIfExists('organization_categories');
    }
};
