<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
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
                            ->maxLength(255),

                        TextInput::make('role')
                            ->label('Rol / cargo')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('bio')
                            ->label('Biografía breve')
                            ->rows(5)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Imagen')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Fotografía')
                            ->image()
                            ->imageEditor()
                            ->directory('team-members')
                            ->visibility('public')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Contacto y redes')
                    ->schema([
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/usuario')
                            ->nullable(),
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
                            ->label('Activo')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}