<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->enum('role_type', [
                'artist',
                'curator',
                'workshop_facilitator',
                'musician',
                'speaker',
                'performer',
                'team',
                'collaborator',
                'other',
            ])->default('artist');
            $table->longText('bio')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 80)->nullable();
            $table->string('website_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('portrait_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 180)->unique();
            $table->text('description')->nullable();
            $table->string('color', 30)->nullable();
            $table->string('icon', 100)->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->foreignId('activity_type_id')->nullable()->constrained('activity_types')->nullOnDelete();
            $table->foreignId('space_id')->nullable()->constrained('spaces')->nullOnDelete();

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->boolean('is_all_day')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->text('recurrence_rule')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('recovery_fee', 10, 2)->nullable();
            $table->boolean('is_free')->default(false);

            $table->boolean('requires_registration')->default(false);
            $table->text('registration_url')->nullable();
            $table->text('external_ticket_url')->nullable();

            $table->string('cover_image')->nullable();
            $table->string('poster_image')->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
                'cancelled',
            ])->default('draft');

            $table->boolean('is_featured')->default(false);
            $table->boolean('show_on_home')->default(true);

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('start_date');
            $table->index('status');
            $table->index('is_featured');
        });

        Schema::create('event_people', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->string('role_label', 120)->nullable();
            $table->primary(['event_id', 'person_id']);
        });

        Schema::create('event_categories', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->primary(['event_id', 'category_id']);
        });

        Schema::create('event_tags', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['event_id', 'tag_id']);
        });

        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220);
            $table->string('original_title', 220)->nullable();
            $table->string('slug', 240)->unique();
            $table->string('director', 180)->nullable();
            $table->string('country', 120)->nullable();
            $table->year('release_year')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('classification', 50)->nullable();
            $table->string('genre', 150)->nullable();
            $table->longText('synopsis')->nullable();
            $table->text('trailer_url')->nullable();
            $table->string('poster_image')->nullable();
            $table->timestamps();
        });

        Schema::create('film_screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();

            $table->string('title', 220);
            $table->string('slug', 240)->unique();

            $table->foreignId('facilitator_id')->nullable()->constrained('people')->nullOnDelete();

            $table->longText('description')->nullable();
            $table->text('materials')->nullable();

            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('commission_percentage', 5, 2)->nullable();

            $table->integer('capacity')->nullable();
            $table->text('registration_instructions')->nullable();

            $table->set('payment_methods', [
                'cash',
                'transfer',
                'online',
                'other',
            ])->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshops');
        Schema::dropIfExists('film_screenings');
        Schema::dropIfExists('films');
        Schema::dropIfExists('event_tags');
        Schema::dropIfExists('event_categories');
        Schema::dropIfExists('event_people');
        Schema::dropIfExists('events');
        Schema::dropIfExists('activity_types');
        Schema::dropIfExists('people');
    }
};