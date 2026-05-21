<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 220)->nullable();
            $table->string('slug', 240)->nullable()->unique();

            $table->enum('media_type', [
                'image',
                'video',
                'audio',
                'pdf',
                'poster',
                'document',
                'other',
            ]);

            $table->text('file_path')->nullable();
            $table->text('external_url')->nullable();
            $table->string('thumbnail_path')->nullable();

            $table->text('caption')->nullable();
            $table->longText('description')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('credit')->nullable();

            $table->date('recorded_at')->nullable();
            $table->year('year')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('show_in_archive')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });

        Schema::create('media_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_item_id')->constrained('media_items')->cascadeOnDelete();

            $table->string('related_type', 100);
            $table->unsignedBigInteger('related_id');

            $table->string('relation_label', 120)->nullable();

            $table->timestamps();

            $table->index(['related_type', 'related_id']);
        });

        Schema::create('media_tags', function (Blueprint $table) {
            $table->foreignId('media_item_id')->constrained('media_items')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

            $table->primary(['media_item_id', 'tag_id']);
        });

        Schema::create('press_items', function (Blueprint $table) {
            $table->id();

            $table->string('title', 220);
            $table->string('slug', 240)->unique();

            $table->string('media_outlet', 180)->nullable();
            $table->string('author', 180)->nullable();
            $table->date('published_date')->nullable();

            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();

            $table->text('external_url')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->boolean('is_featured')->default(false);

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->timestamps();
        });

        Schema::create('press_relations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('press_item_id')->constrained('press_items')->cascadeOnDelete();

            $table->string('related_type', 100);
            $table->unsignedBigInteger('related_id');

            $table->timestamps();

            $table->index(['related_type', 'related_id']);
        });

        Schema::create('calls', function (Blueprint $table) {
            $table->id();

            $table->string('title', 220);
            $table->string('slug', 240)->unique();

            $table->enum('call_type', [
                'exhibition',
                'workshop',
                'event',
                'residency',
                'collaboration',
                'press',
                'general',
            ])->default('general');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->text('form_url')->nullable();
            $table->string('cover_image')->nullable();

            $table->enum('status', [
                'draft',
                'open',
                'closed',
                'archived',
            ])->default('draft');

            $table->timestamps();
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            $table->enum('proposal_type', [
                'exhibition',
                'workshop',
                'event',
                'space_use',
                'press',
                'collaboration',
                'other',
            ]);

            $table->foreignId('call_id')->nullable()->constrained('calls')->nullOnDelete();

            $table->string('name', 180);
            $table->string('email', 180)->nullable();
            $table->string('phone', 80)->nullable();
            $table->string('instagram', 180)->nullable();

            $table->string('title', 220)->nullable();
            $table->longText('description')->nullable();

            $table->foreignId('preferred_space_id')->nullable()->constrained('spaces')->nullOnDelete();

            $table->date('preferred_date')->nullable();
            $table->string('estimated_duration', 120)->nullable();
            $table->text('technical_needs')->nullable();
            $table->text('budget_description')->nullable();

            $table->string('attachment_path')->nullable();

            $table->enum('status', [
                'new',
                'reviewing',
                'accepted',
                'rejected',
                'archived',
            ])->default('new');

            $table->text('internal_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('calls');
        Schema::dropIfExists('press_relations');
        Schema::dropIfExists('press_items');
        Schema::dropIfExists('media_tags');
        Schema::dropIfExists('media_relations');
        Schema::dropIfExists('media_items');
    }
};