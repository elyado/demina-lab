<?php

namespace App\Filament\Resources\Calls\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CallForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('call_type')
                    ->options([
                        'exhibition' => 'Exhibition',
                        'workshop' => 'Workshop',
                        'event' => 'Event',
                        'residency' => 'Residency',
                        'collaboration' => 'Collaboration',
                        'press' => 'Press',
                        'general' => 'General',
                    ])
                    ->default('general')
                    ->required(),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('requirements')
                    ->default(null)
                    ->columnSpanFull(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Textarea::make('form_url')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->label('Imagen de portada')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('calls/covers')
                    ->visibility('public')
                    ->moveFiles()
                    ->nullable(),
                FileUpload::make('pdf_path')
                    ->label('PDF de la convocatoria')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('calls/pdfs')
                    ->visibility('public')
                    ->moveFiles()
                    ->nullable()
                    ->columnSpanFull(),


                Select::make('status')
                    ->options(['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed', 'archived' => 'Archived'])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
