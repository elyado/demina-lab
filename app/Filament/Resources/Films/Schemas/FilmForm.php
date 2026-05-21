<?php

namespace App\Filament\Resources\Films\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FilmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('original_title')
                    ->default(null),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('director')
                    ->default(null),
                TextInput::make('country')
                    ->default(null),
                TextInput::make('release_year')
                    ->default(null),
                TextInput::make('duration_minutes')
                    ->numeric()
                    ->default(null),
                TextInput::make('classification')
                    ->default(null),
                TextInput::make('genre')
                    ->default(null),
                Textarea::make('synopsis')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('trailer_url')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('poster_image')
                    ->image(),
            ]);
    }
}
