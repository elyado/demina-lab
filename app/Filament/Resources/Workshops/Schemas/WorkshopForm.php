<?php

namespace App\Filament\Resources\Workshops\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkshopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('event_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('facilitator_id')
                    ->numeric()
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('materials')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('commission_percentage')
                    ->numeric()
                    ->default(null),
                TextInput::make('capacity')
                    ->numeric()
                    ->default(null),
                Textarea::make('registration_instructions')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('payment_methods')
                    ->default(null),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
