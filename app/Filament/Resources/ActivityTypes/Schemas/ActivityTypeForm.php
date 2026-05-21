<?php

namespace App\Filament\Resources\ActivityTypes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ActivityTypeForm
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

                        ColorPicker::make('color')
                            ->label('Color')
                            ->nullable(),

                        Select::make('icon')
                            ->label('Ícono')
                            ->options([
                                'film' => 'Cine / película',
                                'academic-cap' => 'Taller / formación',
                                'sparkles' => 'Exposición / arte',
                                'musical-note' => 'Música / concierto',
                                'microphone' => 'Charla / presentación',
                                'users' => 'Comunidad / encuentro',
                                'beaker' => 'Laboratorio / experimentación',
                                'paint-brush' => 'Artes visuales',
                                'book-open' => 'Lectura / publicación',
                                'calendar-days' => 'Actividad general',
                            ])
                            ->searchable()
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Configuración')
                    ->schema([
                        Toggle::make('is_recurring')
                            ->label('Actividad recurrente')
                            ->helperText('Actívalo para tipos de actividad que suelen repetirse, como cineclub, talleres semanales o laboratorios.')
                            ->default(false)
                            ->required(),

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