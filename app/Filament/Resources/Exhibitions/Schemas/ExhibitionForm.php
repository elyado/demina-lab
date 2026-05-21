<?php

namespace App\Filament\Resources\Exhibitions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExhibitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('subtitle')
                    ->default(null),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('curatorial_text')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('curator_id')
                    ->numeric()
                    ->default(null),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                DatePicker::make('opening_date'),
                TimePicker::make('opening_time'),
                FileUpload::make('cover_image')
                    ->image(),
                FileUpload::make('poster_image')
                    ->image(),
                Select::make('exhibition_type')
                    ->options(['collective' => 'Collective', 'individual' => 'Individual', 'duo' => 'Duo', 'other' => 'Other'])
                    ->default('collective')
                    ->required(),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'current' => 'Current',
            'upcoming' => 'Upcoming',
            'past' => 'Past',
            'archived' => 'Archived',
        ])
                    ->default('draft')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('show_on_home')
                    ->required(),
                TextInput::make('seo_title')
                    ->default(null),
                Textarea::make('seo_description')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
