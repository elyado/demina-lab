<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('film_title', 220)->nullable()->after('description');
            $table->string('film_original_title', 220)->nullable()->after('film_title');
            $table->string('film_director', 180)->nullable()->after('film_original_title');
            $table->string('film_country', 120)->nullable()->after('film_director');
            $table->year('film_year')->nullable()->after('film_country');
            $table->integer('film_duration_minutes')->nullable()->after('film_year');
            $table->string('film_classification', 50)->nullable()->after('film_duration_minutes');
            $table->string('film_genre', 150)->nullable()->after('film_classification');
            $table->longText('film_synopsis')->nullable()->after('film_genre');
            $table->text('film_trailer_url')->nullable()->after('film_synopsis');
            $table->string('film_poster_image')->nullable()->after('film_trailer_url');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'film_title',
                'film_original_title',
                'film_director',
                'film_country',
                'film_year',
                'film_duration_minutes',
                'film_classification',
                'film_genre',
                'film_synopsis',
                'film_trailer_url',
                'film_poster_image',
            ]);
        });
    }
};