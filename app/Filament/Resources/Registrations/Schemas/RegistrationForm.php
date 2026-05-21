<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Actividad')
                    ->description('Relaciona el registro con un evento, taller o ambos.')
                    ->schema([
                        Select::make('event_id')
                            ->label('Evento')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('workshop_id')
                            ->label('Taller')
                            ->relationship('workshop', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Datos de la persona')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(50)
                            ->nullable(),

                        TextInput::make('number_of_people')
                            ->label('Número de personas')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1),
                    ])
                    ->columns(2),

                Section::make('Pago y estado')
                    ->schema([
                        Select::make('payment_method')
                            ->label('Método de pago')
                            ->options([
                                'cash' => 'Efectivo',
                                'transfer' => 'Transferencia',
                                'none' => 'No aplica',
                                'other' => 'Otro',
                            ])
                            ->default('none')
                            ->required(),

                        Select::make('payment_status')
                            ->label('Estado del pago')
                            ->options([
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'not_required' => 'No requerido',
                            ])
                            ->default('pending')
                            ->required(),

                        Select::make('status')
                            ->label('Estado del registro')
                            ->options([
                                'new' => 'Nuevo',
                                'confirmed' => 'Confirmado',
                                'cancelled' => 'Cancelado',
                                'attended' => 'Asistió',
                                'no_show' => 'No asistió',
                            ])
                            ->default('new')
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Notas')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas internas')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}