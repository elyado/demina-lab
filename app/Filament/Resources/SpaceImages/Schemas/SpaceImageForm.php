<?php

namespace App\Filament\Resources\SpaceImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SpaceImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Espacio')
                    ->schema([
                        Select::make('space_id')
                            ->label('Espacio')
                            ->relationship('space', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Section::make('Imagen')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Imagen')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('spaces')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Información de la imagen')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('alt_text')
                            ->label('Texto alternativo')
                            ->helperText('Describe brevemente la imagen. Sirve para accesibilidad y SEO.')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('caption')
                            ->label('Pie de foto')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
