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
        Schema::create('upbjj_zones', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50); // Contoh: ZONA 01, ZONA LN
            $table->string('name'); // Contoh: UPBJJ Wilayah Jawa Barat, DKI Jakarta & Banten (Pusat Cirebon)
            $table->text('coverage'); // Cakupan Provinsi / Kota & Sentra Pokjar
            $table->string('partner')->nullable(); // Mitra Koordinasi Wilayah
            $table->string('coordinator_name')->nullable(); // Nama Koordinator / Kepala Sentra Wilayah
            $table->string('phone')->nullable(); // Kontak / WhatsApp Wilayah
            $table->text('address')->nullable(); // Alamat Sekretariat / Sentra Layanan Wilayah
            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upbjj_zones');
    }
};

