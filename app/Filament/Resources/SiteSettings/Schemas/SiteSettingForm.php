<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identidad del sitio')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nombre del sitio')
                            ->required()
                            ->default('Demina Laboratorio de Artes'),

                        TextInput::make('tagline')
                            ->label('Tagline / frase breve')
                            ->default(null),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->default(null)
                            ->columnSpanFull(),

                        Textarea::make('manifesto')
                            ->label('Manifiesto')
                            ->rows(6)
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Ubicación y contacto')
                    ->schema([
                        Textarea::make('address')
                            ->label('Dirección')
                            ->default(null)
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->label('Ciudad')
                            ->required()
                            ->default('Acapulco'),

                        TextInput::make('state')
                            ->label('Estado')
                            ->required()
                            ->default('Guerrero'),

                        TextInput::make('country')
                            ->label('País')
                            ->required()
                            ->default('México'),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->default(null),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->default(null),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->default(null),
                    ])
                    ->columns(2),

                Section::make('Redes y enlaces')
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->default(null),

                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->default(null),

                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url()
                            ->default(null),

                        TextInput::make('tiktok_url')
                            ->label('TikTok')
                            ->url()
                            ->default(null),

                        Textarea::make('google_maps_url')
                            ->label('Google Maps URL')
                            ->default(null)
                            ->columnSpanFull(),

                        Textarea::make('press_kit_url')
                            ->label('Press kit URL')
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Marca')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logotipo')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('site')
                            ->visibility('public')
                            ->moveFiles()
                            ->nullable(),

                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->visibility('public')
                            ->moveFiles()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Imágenes del home')
                    ->description('Imágenes principales usadas en la página de inicio pública.')
                    ->schema([
                        FileUpload::make('hero_image_path')
                            ->label('Imagen principal del home')
                            ->helperText('Imagen grande para el hero superior de la página de inicio.')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('site/home')
                            ->visibility('public')
                            ->moveFiles()
                            ->nullable()
                            ->columnSpanFull(),

                        FileUpload::make('community_image_path')
                            ->label('Imagen de comunidad del home')
                            ->helperText('Imagen para la sección final de comunidad en la página de inicio.')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('site/home')
                            ->visibility('public')
                            ->moveFiles()
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}