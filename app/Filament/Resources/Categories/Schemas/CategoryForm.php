<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información principal')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'event' => 'Evento',
                                'exhibition' => 'Exposición',
                                'archive' => 'Archivo',
                                'press' => 'Prensa',
                                'workshop' => 'Taller',
                                'space' => 'Espacio',
                                'general' => 'General',
                            ])
                            ->default('general')
                            ->required(),

                        ColorPicker::make('color')
                            ->label('Color')
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Publicación')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}