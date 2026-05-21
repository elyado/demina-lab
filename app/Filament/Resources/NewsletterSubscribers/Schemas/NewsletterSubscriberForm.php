<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del suscriptor')
                    ->schema([
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('name')
                            ->label('Nombre')
                            ->maxLength(255)
                            ->nullable(),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'subscribed' => 'Suscrito',
                                'unsubscribed' => 'Dado de baja',
                            ])
                            ->default('subscribed')
                            ->required(),

                        TextInput::make('source')
                            ->label('Origen')
                            ->maxLength(255)
                            ->placeholder('Formulario web, evento, taller, importación...')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }
}