<?php

namespace App\Filament\Resources\CallApplications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CallApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('folio')
                    ->required(),
                TextInput::make('call_name')
                    ->required()
                    ->default('Convocatoria Fotográfica Gatillo'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('age')
                    ->numeric()
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('whatsapp')
                    ->default(null),
                TextInput::make('pseudonym')
                    ->default(null),
                TextInput::make('capture_year')
                    ->default(null),
                TextInput::make('technique_support')
                    ->default(null),
                TextInput::make('dimensions')
                    ->default(null),
                TextInput::make('edition')
                    ->default(null),
                TextInput::make('production_cost')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('sale_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                Textarea::make('intention_note')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('bio')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'received' => 'Received',
            'reviewing' => 'Reviewing',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'archived' => 'Archived',
        ])
                    ->default('received')
                    ->required(),
                Textarea::make('internal_notes')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('submitted_at'),
            ]);
    }
}
