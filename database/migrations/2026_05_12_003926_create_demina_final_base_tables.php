<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('role', 180)->nullable();
            $table->text('bio')->nullable();
            $table->string('image_path')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('instagram_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('website_url')->nullable();

            $table->enum('partner_type', [
                'space',
                'collective',
                'institution',
                'artist_group',
                'sponsor',
                'other',
            ])->default('other');

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('template', 100)->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 180)->unique();
            $table->string('name', 180)->nullable();

            $table->enum('status', [
                'subscribed',
                'unsubscribed',
            ])->default('subscribed');

            $table->string('source', 120)->nullable();
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->foreignId('workshop_id')->nullable()->constrained('workshops')->nullOnDelete();

            $table->string('name', 180);
            $table->string('email', 180)->nullable();
            $table->string('phone', 80)->nullable();

            $table->integer('number_of_people')->default(1);

            $table->enum('payment_method', [
                'cash',
                'transfer',
                'none',
                'other',
            ])->default('none');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'not_required',
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'new',
                'confirmed',
                'cancelled',
                'attended',
                'no_show',
            ])->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('team_members');
    }
};