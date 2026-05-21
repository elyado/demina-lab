<?php

namespace App\Filament\Resources\MediaItems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MediaItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->default(null),
                TextInput::make('slug')
                    ->default(null),
                Select::make('media_type')
                    ->options([
            'image' => 'Image',
            'video' => 'Video',
            'audio' => 'Audio',
            'pdf' => 'Pdf',
            'poster' => 'Poster',
            'document' => 'Document',
            'other' => 'Other',
        ])
                    ->required(),
                Textarea::make('file_path')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('external_url')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('thumbnail_path')
                    ->default(null),
                Textarea::make('caption')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('alt_text')
                    ->default(null),
                TextInput::make('credit')
                    ->default(null),
                DatePicker::make('recorded_at'),
                TextInput::make('year')
                    ->default(null),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('show_in_archive')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
