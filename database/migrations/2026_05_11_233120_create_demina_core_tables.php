<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name', 150)->default('Demina Laboratorio de Artes');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->longText('manifesto')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 150)->default('Acapulco');
            $table->string('state', 150)->default('Guerrero');
            $table->string('country', 150)->default('México');
            $table->string('phone', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->text('press_kit_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 180)->unique();
            $table->enum('type', [
                'event',
                'exhibition',
                'archive',
                'press',
                'workshop',
                'space',
                'general',
            ])->default('general');
            $table->text('description')->nullable();
            $table->string('color', 30)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 180)->unique();
            $table->timestamps();
        });

        Schema::create('spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('floor_level', 100)->nullable();
            $table->integer('capacity')->nullable();
            $table->text('usage_description')->nullable();
            $table->text('schedule_description')->nullable();
            $table->boolean('rental_available')->default(false);
            $table->boolean('barter_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('cover_image')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 180)->unique();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->boolean('is_general')->default(true);
            $table->timestamps();
        });

        Schema::create('equipment_space', function (Blueprint $table) {
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->foreignId('space_id')->constrained('spaces')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->primary(['equipment_id', 'space_id']);
        });

        Schema::create('space_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('space_id')->constrained('spaces')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('title', 180)->nullable();
            $table->text('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('space_images');
        Schema::dropIfExists('equipment_space');
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('spaces');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('site_settings');
    }
};