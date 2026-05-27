<?php

namespace App\Filament\Resources\Spaces;

use App\Filament\Resources\Spaces\Pages\CreateSpace;
use App\Filament\Resources\Spaces\Pages\EditSpace;
use App\Filament\Resources\Spaces\Pages\ListSpaces;
use App\Filament\Resources\Spaces\Schemas\SpaceForm;
use App\Filament\Resources\Spaces\Tables\SpacesTable;
use App\Models\Space;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SpaceResource extends Resource
{
    protected static ?string $model = Space::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Espacios';
    protected static ?string $navigationLabel = 'Espacios';
    protected static ?string $modelLabel = 'espacio';
    protected static ?string $pluralModelLabel = 'espacios';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información general')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(200),

                        \Filament\Forms\Components\TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('short_description')
                            ->label('Descripción corta')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción completa')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Datos del espacio')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('floor_level')
                            ->label('Nivel / piso')
                            ->maxLength(100),

                        \Filament\Forms\Components\TextInput::make('capacity')
                            ->label('Capacidad')
                            ->numeric(),

                        \Filament\Forms\Components\Textarea::make('usage_description')
                            ->label('Usos posibles')
                            ->rows(3),

                        \Filament\Forms\Components\Textarea::make('schedule_description')
                            ->label('Horario / disponibilidad')
                            ->rows(3),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Disponibilidad')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('rental_available')
                            ->label('Disponible para renta'),

                        \Filament\Forms\Components\Toggle::make('barter_available')
                            ->label('Disponible para trueque / colaboración'),

                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Destacado'),

                        \Filament\Forms\Components\Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imagen')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('spaces/covers'),
                    ]),

                \Filament\Schemas\Components\Section::make('SEO')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(255),

                        \Filament\Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Espacio')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('floor_level')
                    ->label('Nivel / piso')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('capacity')
                    ->label('Capacidad')
                    ->sortable(),

                \Filament\Tables\Columns\IconColumn::make('rental_available')
                    ->label('Renta')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('barter_available')
                    ->label('Trueque')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),

                \Filament\Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo'),

                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destacado'),

                \Filament\Tables\Filters\TernaryFilter::make('rental_available')
                    ->label('Disponible para renta'),
            ])
            ->defaultSort('sort_order')
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListSpaces::route('/'),
            'create' => CreateSpace::route('/create'),
            'edit' => EditSpace::route('/{record}/edit'),
        ];
    }
}
