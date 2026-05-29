<?php

namespace App\Filament\Resources\Cineclubs;

use App\Filament\Resources\Cineclubs\Pages;
use App\Models\ActivityType;
use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CineclubResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $slug = 'cineclub';

    protected static string|\UnitEnum|null $navigationGroup = 'Programación';
    protected static ?string $navigationLabel = 'Cineclub';
    protected static ?string $modelLabel = 'función de cineclub';
    protected static ?string $pluralModelLabel = 'cineclub';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-film';
    protected static ?int $navigationSort = 1;
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('activityType', fn(Builder $query) => $query->where('slug', 'cineclub'));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('activity_type_id')
                    ->default(fn() => ActivityType::where('slug', 'cineclub')->value('id'))
                    ->dehydrated(),

                Hidden::make('title')
                    ->dehydrated(),

                Section::make('Película')
                    ->schema([
                        TextInput::make('film_title')
                            ->label('Título de la película')
                            ->required()
                            ->maxLength(220)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('title', $state);
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(table: 'events', column: 'slug', ignoreRecord: true)
                            ->maxLength(240),

                        TextInput::make('film_original_title')
                            ->label('Título original')
                            ->maxLength(220),

                        TextInput::make('film_director')
                            ->label('Dirección')
                            ->maxLength(180),

                        TextInput::make('film_country')
                            ->label('País')
                            ->maxLength(120),

                        TextInput::make('film_year')
                            ->label('Año')
                            ->numeric(),

                        TextInput::make('film_duration_minutes')
                            ->label('Duración')
                            ->numeric()
                            ->suffix('min'),

                        TextInput::make('film_classification')
                            ->label('Clasificación')
                            ->maxLength(50),

                        TextInput::make('film_genre')
                            ->label('Género')
                            ->maxLength(150),

                        RichEditor::make('film_synopsis')
                            ->label('Sinopsis')
                            ->columnSpanFull(),

                        TextInput::make('film_trailer_url')
                            ->label('Trailer URL')
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Función')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Fecha')
                            ->required(),

                        TimePicker::make('start_time')
                            ->label('Hora')
                            ->seconds(false),

                        Select::make('space_id')
                            ->label('Espacio')
                            ->relationship('space', 'name')
                            ->searchable()
                            ->preload(),

                        Toggle::make('is_free')
                            ->label('Entrada libre')
                            ->default(true),

                        TextInput::make('recovery_fee')
                            ->label('Cuota de recuperación')
                            ->numeric()
                            ->prefix('$'),

                        FileUpload::make('film_poster_image')
                            ->label('Poster / cartel')
                            ->image()
                            ->directory('events/cineclub/posters')
                            ->disk('public')
                            ->visibility('public'),

                        FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->directory('events/cineclub/covers')
                            ->disk('public')
                            ->visibility('public'),
                    ])
                    ->columns(2),

                Section::make('Publicación')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'published' => 'Publicado',
                                'archived' => 'Archivado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->default('draft')
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Destacada'),

                        Toggle::make('show_on_home')
                            ->label('Mostrar en inicio')
                            ->default(true),

                        DateTimePicker::make('published_at')
                            ->label('Fecha de publicación'),

                        TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(255),

                        RichEditor::make('description')
                            ->label('Texto editorial / comentario')
                            ->columnSpanFull(),

                        TextInput::make('seo_description')
                            ->label('Descripción SEO')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('film_title')
                    ->label('Película')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->formatStateUsing(fn($state, $record) => $state ?: $record->title),

                TextColumn::make('film_director')
                    ->label('Dirección')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Hora')
                    ->time('H:i'),

                TextColumn::make('space.name')
                    ->label('Espacio')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('is_featured')
                    ->label('Destacada')
                    ->boolean(),

                IconColumn::make('show_on_home')
                    ->label('Inicio')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->defaultSort('start_date', 'desc')
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCineclubs::route('/'),
            'create' => Pages\CreateCineclub::route('/create'),
            'edit' => Pages\EditCineclub::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
{
    return auth()->user()?->isAdmin() ?? false;
}
}
