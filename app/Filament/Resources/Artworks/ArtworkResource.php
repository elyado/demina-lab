<?php

namespace App\Filament\Resources\Artworks;

use App\Filament\Resources\Artworks\Pages\CreateArtwork;
use App\Filament\Resources\Artworks\Pages\EditArtwork;
use App\Filament\Resources\Artworks\Pages\ListArtworks;
use App\Filament\Resources\Artworks\Schemas\ArtworkForm;
use App\Filament\Resources\Artworks\Tables\ArtworksTable;
use App\Models\Artwork;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArtworkResource extends Resource
{
    protected static ?string $model = Artwork::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Exposiciones / Obras';
    protected static ?string $navigationLabel = 'Obras';
    protected static ?string $modelLabel = 'Obra';
    protected static ?string $pluralModelLabel = 'Obras';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información de la obra')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(220)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(240),

                        \Filament\Forms\Components\Select::make('artist_id')
                            ->label('Artista')
                            ->relationship('artist', 'name')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('exhibition_id')
                            ->label('Exposición')
                            ->relationship('exhibition', 'title')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\TextInput::make('year')
                            ->label('Año')
                            ->maxLength(50),

                        \Filament\Forms\Components\TextInput::make('technique')
                            ->label('Técnica'),

                        \Filament\Forms\Components\TextInput::make('dimensions')
                            ->label('Dimensiones'),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imagen')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->label('Imagen de la obra')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('artworks'),
                    ]),

                \Filament\Schemas\Components\Section::make('Venta / disponibilidad')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_for_sale')
                            ->label('Disponible para venta'),

                        \Filament\Forms\Components\TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->prefix('$'),

                        \Filament\Forms\Components\TextInput::make('currency')
                            ->label('Moneda')
                            ->default('MXN')
                            ->maxLength(10),

                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'available' => 'Disponible',
                                'sold' => 'Vendida',
                                'not_for_sale' => 'No está en venta',
                                'reserved' => 'Reservada',
                            ])
                            ->default('not_for_sale')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ArtworksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtworks::route('/'),
            'create' => CreateArtwork::route('/create'),
            'edit' => EditArtwork::route('/{record}/edit'),
        ];
    }
}
