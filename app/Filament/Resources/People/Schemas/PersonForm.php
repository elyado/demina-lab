<?php

namespace App\Filament\Resources\People\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('role_type')
                    ->options([
            'artist' => 'Artist',
            'curator' => 'Curator',
            'workshop_facilitator' => 'Workshop facilitator',
            'musician' => 'Musician',
            'speaker' => 'Speaker',
            'performer' => 'Performer',
            'team' => 'Team',
            'collaborator' => 'Collaborator',
            'other' => 'Other',
        ])
                    ->default('artist')
                    ->required(),
                Textarea::make('bio')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('short_bio')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('website_url')
                    ->url()
                    ->default(null),
                TextInput::make('instagram_url')
                    ->url()
                    ->default(null),
                TextInput::make('facebook_url')
                    ->url()
                    ->default(null),
                FileUpload::make('portrait_image')
                    ->image(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
