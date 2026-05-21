<?php

namespace App\Filament\Resources\Artworks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArtworkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('artist_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('exhibition_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('year')
                    ->default(null),
                TextInput::make('technique')
                    ->default(null),
                TextInput::make('dimensions')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->image(),
                Toggle::make('is_for_sale')
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('currency')
                    ->required()
                    ->default('MXN'),
                Select::make('status')
                    ->options([
            'available' => 'Available',
            'sold' => 'Sold',
            'not_for_sale' => 'Not for sale',
            'reserved' => 'Reserved',
        ])
                    ->default('not_for_sale')
                    ->required(),
            ]);
    }
}
