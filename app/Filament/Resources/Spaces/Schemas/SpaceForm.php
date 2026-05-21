<?php

namespace App\Filament\Resources\Spaces\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SpaceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('subtitle')
                    ->default(null),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('floor_level')
                    ->default(null),
                TextInput::make('capacity')
                    ->numeric()
                    ->default(null),
                Textarea::make('usage_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('schedule_description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('rental_available')
                    ->required(),
                Toggle::make('barter_available')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('seo_title')
                    ->default(null),
                Textarea::make('seo_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
