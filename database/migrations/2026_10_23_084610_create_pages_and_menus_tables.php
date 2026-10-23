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
        // 1. Pages table (Dynamic Pages / Halaman Dinamis)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('template')->default('default'); // default, full-width, blank
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 2. Menu Items table (Dynamic Menu Builder)
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('location')->default('header')->index(); // header, footer
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->default('custom'); // page, route, custom
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('route_name')->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('icon')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_color')->default('emerald');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('pages');
    }
};
