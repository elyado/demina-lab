<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('curatorial_text')->nullable();

            $table->foreignId('curator_id')->nullable()->constrained('people')->nullOnDelete();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('opening_date')->nullable();
            $table->time('opening_time')->nullable();

            $table->string('cover_image')->nullable();
            $table->string('poster_image')->nullable();

            $table->enum('exhibition_type', [
                'collective',
                'individual',
                'duo',
                'other',
            ])->default('collective');

            $table->enum('status', [
                'draft',
                'current',
                'upcoming',
                'past',
                'archived',
            ])->default('draft');

            $table->boolean('is_featured')->default(false);
            $table->boolean('show_on_home')->default(true);

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['start_date', 'end_date']);
            $table->index('status');
        });

        Schema::create('exhibition_spaces', function (Blueprint $table) {
            $table->foreignId('exhibition_id')->constrained('exhibitions')->cascadeOnDelete();
            $table->foreignId('space_id')->constrained('spaces')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->primary(['exhibition_id', 'space_id']);
        });

        Schema::create('exhibition_people', function (Blueprint $table) {
            $table->foreignId('exhibition_id')->constrained('exhibitions')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('role_label', 120)->nullable();
            $table->primary(['exhibition_id', 'person_id']);
        });

        Schema::create('exhibition_events', function (Blueprint $table) {
            $table->foreignId('exhibition_id')->constrained('exhibitions')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('relation_label', 120)->nullable();
            $table->primary(['exhibition_id', 'event_id']);
        });

        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();

            $table->foreignId('artist_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('exhibition_id')->nullable()->constrained('exhibitions')->nullOnDelete();

            $table->string('year', 50)->nullable();
            $table->string('technique')->nullable();
            $table->string('dimensions')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();

            $table->boolean('is_for_sale')->default(false);
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 10)->default('MXN');

            $table->enum('status', [
                'available',
                'sold',
                'not_for_sale',
                'reserved',
            ])->default('not_for_sale');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
        Schema::dropIfExists('exhibition_events');
        Schema::dropIfExists('exhibition_people');
        Schema::dropIfExists('exhibition_spaces');
        Schema::dropIfExists('exhibitions');
    }
};