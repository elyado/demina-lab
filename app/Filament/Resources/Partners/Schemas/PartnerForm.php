<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PartnerForm
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

                        Select::make('partner_type')
                            ->label('Tipo de aliado')
                            ->options([
                                'space' => 'Espacio',
                                'collective' => 'Colectivo',
                                'institution' => 'Institución',
                                'artist_group' => 'Grupo artístico',
                                'sponsor' => 'Patrocinador',
                                'other' => 'Otro',
                            ])
                            ->default('other')
                            ->required(),

                        TextInput::make('website_url')
                            ->label('Sitio web')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://ejemplo.com')
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(5)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Logo')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->imageEditor()
                            ->directory('partners')
                            ->visibility('public')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Publicación')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}