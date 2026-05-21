<?php

namespace App\Filament\Resources\Proposals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProposalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('proposal_type')
                    ->options([
            'exhibition' => 'Exhibition',
            'workshop' => 'Workshop',
            'event' => 'Event',
            'space_use' => 'Space use',
            'press' => 'Press',
            'collaboration' => 'Collaboration',
            'other' => 'Other',
        ])
                    ->required(),
                TextInput::make('call_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('instagram')
                    ->default(null),
                TextInput::make('title')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('preferred_space_id')
                    ->numeric()
                    ->default(null),
                DatePicker::make('preferred_date'),
                TextInput::make('estimated_duration')
                    ->default(null),
                Textarea::make('technical_needs')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('budget_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('attachment_path')
                    ->default(null),
                Select::make('status')
                    ->options([
            'new' => 'New',
            'reviewing' => 'Reviewing',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'archived' => 'Archived',
        ])
                    ->default('new')
                    ->required(),
                Textarea::make('internal_notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
