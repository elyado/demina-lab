<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Programación';
    protected static ?string $navigationLabel = 'Eventos';
    protected static ?string $modelLabel = 'Evento';
    protected static ?string $pluralModelLabel = 'Eventos';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 2;


    protected static ?string $recordTitleAttribute = 'tilte';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información general')
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

                        \Filament\Forms\Components\TextInput::make('subtitle')
                            ->label('Subtítulo')
                            ->maxLength(255),

                        \Filament\Forms\Components\Textarea::make('short_description')
                            ->label('Descripción corta')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción completa')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Lugar y tipo de actividad')
                    ->schema([
                        \Filament\Forms\Components\Select::make('activity_type_id')
                            ->label('Tipo de actividad')
                            ->relationship(
                                'activityType',
                                'name',
                                fn(\Illuminate\Database\Eloquent\Builder $query) => $query->where('slug', '!=', 'cineclub')
                            )
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\Select::make('space_id')
                            ->label('Espacio')
                            ->relationship('space', 'name')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('people')
                            ->label('Personas participantes')
                            ->relationship('people', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('categories')
                            ->label('Categorías')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('tags')
                            ->label('Etiquetas')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                    ])
                    ->columns(2),


                \Filament\Schemas\Components\Section::make('Fecha y horario')
                    ->schema([
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Fecha de inicio')
                            ->required(),

                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha de cierre'),

                        \Filament\Forms\Components\TimePicker::make('start_time')
                            ->label('Hora de inicio')
                            ->seconds(false),

                        \Filament\Forms\Components\TimePicker::make('end_time')
                            ->label('Hora de cierre')
                            ->seconds(false),

                        \Filament\Forms\Components\Toggle::make('is_all_day')
                            ->label('Todo el día'),

                        \Filament\Forms\Components\Toggle::make('is_recurring')
                            ->label('Evento recurrente'),

                        \Filament\Forms\Components\Textarea::make('recurrence_rule')
                            ->label('Regla de recurrencia')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Precio y registro')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_free')
                            ->label('Entrada libre'),

                        \Filament\Forms\Components\TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->prefix('$'),

                        \Filament\Forms\Components\TextInput::make('recovery_fee')
                            ->label('Cuota de recuperación')
                            ->numeric()
                            ->prefix('$'),

                        \Filament\Forms\Components\Toggle::make('requires_registration')
                            ->label('Requiere registro'),

                        \Filament\Forms\Components\Textarea::make('registration_url')
                            ->label('URL de registro')
                            ->rows(2),

                        \Filament\Forms\Components\Textarea::make('external_ticket_url')
                            ->label('URL de boletos')
                            ->rows(2),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imágenes')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('events/covers'),

                        \Filament\Forms\Components\FileUpload::make('poster_image')
                            ->label('Cartel')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('events/posters'),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Publicación y SEO')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'published' => 'Publicado',
                                'archived' => 'Archivado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->default('draft')
                            ->required(),

                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Destacado'),

                        \Filament\Forms\Components\Toggle::make('show_on_home')
                            ->label('Mostrar en inicio')
                            ->default(true),

                        \Filament\Forms\Components\DateTimePicker::make('published_at')
                            ->label('Fecha de publicación'),

                        \Filament\Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO')
                            ->maxLength(255),

                        \Filament\Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Evento')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('activityType.name')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('space.name')
                    ->label('Espacio')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('start_time')
                    ->label('Hora')
                    ->time('H:i')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
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

                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('show_on_home')
                    ->label('Inicio')
                    ->boolean(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                        'cancelled' => 'Cancelado',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('activity_type_id')
                    ->label('Tipo de actividad')
                    ->relationship('activityType', 'name'),

                \Filament\Tables\Filters\SelectFilter::make('space_id')
                    ->label('Espacio')
                    ->relationship('space', 'name'),
            ])
            ->defaultSort('start_date', 'desc')
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
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereDoesntHave('activityType', fn(Builder $query) => $query->where('slug', 'cineclub'));
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
