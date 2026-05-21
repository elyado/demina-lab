<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del equipo')
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

                        TextInput::make('quantity')
                            ->label('Cantidad')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(1),

                        Toggle::make('is_general')
                            ->label('Equipo general')
                            ->helperText('Actívalo si este equipo pertenece al inventario general y no solo a un espacio específico.')
                            ->default(false)
                            ->required(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Espacios relacionados')
                    ->schema([
                        Select::make('spaces')
                            ->label('Espacios')
                            ->relationship('spaces', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->helperText('Selecciona los espacios donde este equipo está disponible.')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}