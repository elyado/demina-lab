<?php

namespace App\Filament\Resources\PressItems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PressItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información principal')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
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

                        TextInput::make('media_outlet')
                            ->label('Medio')
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('author')
                            ->label('Autor / autora')
                            ->maxLength(255)
                            ->nullable(),

                        DatePicker::make('published_date')
                            ->label('Fecha de publicación')
                            ->native(false)
                            ->nullable(),

                        TextInput::make('external_url')
                            ->label('URL externa')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://ejemplo.com/nota')
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Contenido')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Extracto')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('body')
                            ->label('Contenido / notas internas')
                            ->rows(8)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Imagen y archivo')
                    ->schema([
                        FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('press/covers')
                            ->visibility('public')
                            ->moveFiles()
                            ->nullable()
                            ->columnSpanFull(),

                        FileUpload::make('file_path')
                            ->label('Archivo adjunto')
                            ->directory('press/files')
                            ->disk('public')
                            ->visibility('public')
                            ->moveFiles()
                            ->columnSpanFull()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Publicación')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'published' => 'Publicado',
                                'archived' => 'Archivado',
                            ])
                            ->default('draft')
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Destacado')
                            ->default(false)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->rows(3)
                            ->maxLength(500)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
