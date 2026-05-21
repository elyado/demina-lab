<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
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
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('activity_type_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('space_id')
                    ->numeric()
                    ->default(null),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                Toggle::make('is_all_day')
                    ->required(),
                Toggle::make('is_recurring')
                    ->required(),
                Textarea::make('recurrence_rule')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('recovery_fee')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_free')
                    ->required(),
                Toggle::make('requires_registration')
                    ->required(),
                Textarea::make('registration_url')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('external_ticket_url')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->label('Imagen de portada')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('events/covers')
                    ->visibility('public')
                    ->moveFiles()
                    ->nullable()
                    ->columnSpanFull(),

                FileUpload::make('poster_image')
                    ->label('Cartel / póster')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('events/posters')
                    ->visibility('public')
                    ->moveFiles()
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                        'cancelled' => 'Cancelled',
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
