<?php

namespace App\Filament\Resources\MediaItems;

use App\Filament\Resources\MediaItems\Pages\CreateMediaItem;
use App\Filament\Resources\MediaItems\Pages\EditMediaItem;
use App\Filament\Resources\MediaItems\Pages\ListMediaItems;
use App\Filament\Resources\MediaItems\Schemas\MediaItemForm;
use App\Filament\Resources\MediaItems\Tables\MediaItemsTable;
use App\Models\MediaItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Archivos / Medios';
    protected static ?string $navigationLabel = 'Archivo multimedia';
    protected static ?string $modelLabel = 'Archivo multimedia';
    protected static ?string $pluralModelLabel = 'Archivo multimedia';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tilte';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información general')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->maxLength(220)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(240),

                        \Filament\Forms\Components\Select::make('media_type')
                            ->label('Tipo de medio')
                            ->options([
                                'image' => 'Imagen',
                                'video' => 'Video',
                                'audio' => 'Audio',
                                'pdf' => 'PDF',
                                'poster' => 'Cartel',
                                'document' => 'Documento',
                                'other' => 'Otro',
                            ])
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('caption')
                            ->label('Pie de foto / caption')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Archivo o enlace externo')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('file_path')
                            ->label('Archivo')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('media/files'),
                            

                        \Filament\Forms\Components\TextInput::make('external_url')
                            ->label('URL externa')
                            ->url(),

                        \Filament\Forms\Components\FileUpload::make('thumbnail_path')
                            ->label('Miniatura')
                            ->image()->disk('public')
                            ->visibility('public')
                            ->directory('media/thumbnails'),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Créditos y accesibilidad')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('alt_text')
                            ->label('Texto alternativo')
                            ->maxLength(255),

                        \Filament\Forms\Components\TextInput::make('credit')
                            ->label('Crédito')
                            ->maxLength(255),

                        \Filament\Forms\Components\DatePicker::make('recorded_at')
                            ->label('Fecha de registro'),

                        \Filament\Forms\Components\TextInput::make('year')
                            ->label('Año')
                            ->numeric(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Visibilidad')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Destacado'),

                        \Filament\Forms\Components\Toggle::make('show_in_archive')
                            ->label('Mostrar en archivo')
                            ->default(true),

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
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('media_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'image' => 'Imagen',
                        'video' => 'Video',
                        'audio' => 'Audio',
                        'pdf' => 'PDF',
                        'poster' => 'Cartel',
                        'document' => 'Documento',
                        'other' => 'Otro',
                        default => $state,
                    }),

                \Filament\Tables\Columns\TextColumn::make('credit')
                    ->label('Crédito')
                    ->searchable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('recorded_at')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('year')
                    ->label('Año')
                    ->sortable(),

                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('show_in_archive')
                    ->label('Archivo')
                    ->boolean(),

                \Filament\Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('media_type')
                    ->label('Tipo de medio')
                    ->options([
                        'image' => 'Imagen',
                        'video' => 'Video',
                        'audio' => 'Audio',
                        'pdf' => 'PDF',
                        'poster' => 'Cartel',
                        'document' => 'Documento',
                        'other' => 'Otro',
                    ]),

                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destacado'),

                \Filament\Tables\Filters\TernaryFilter::make('show_in_archive')
                    ->label('Mostrar en archivo'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => ListMediaItems::route('/'),
            'create' => CreateMediaItem::route('/create'),
            'edit' => EditMediaItem::route('/{record}/edit'),
        ];
    }
}
