<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_applications', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 40)->unique();
            $table->string('call_name')->default('Convocatoria Fotográfica Gatillo');

            $table->string('name', 180);
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('email', 180);
            $table->string('phone', 80)->nullable();
            $table->string('whatsapp', 80)->nullable();
            $table->string('pseudonym', 180)->nullable();

            $table->string('capture_year', 50)->nullable();
            $table->string('technique_support')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('edition')->nullable();
            $table->decimal('production_cost', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();

            $table->text('intention_note')->nullable();
            $table->longText('bio')->nullable();

            $table->enum('status', [
                'received',
                'reviewing',
                'accepted',
                'rejected',
                'archived',
            ])->default('received');

            $table->text('internal_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });

        Schema::create('call_application_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_application_id')
                ->constrained('call_applications')
                ->cascadeOnDelete();

            $table->string('title', 220);
            $table->string('file_path');
            $table->string('original_filename')->nullable();
            $table->string('mime_type', 120)->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_application_photos');
        Schema::dropIfExists('call_applications');
    }
};