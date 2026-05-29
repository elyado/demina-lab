<?php

namespace App\Filament\Resources\Exhibitions;

use App\Filament\Resources\Exhibitions\Pages\CreateExhibition;
use App\Filament\Resources\Exhibitions\Pages\EditExhibition;
use App\Filament\Resources\Exhibitions\Pages\ListExhibitions;
use App\Filament\Resources\Exhibitions\Schemas\ExhibitionForm;
use App\Filament\Resources\Exhibitions\Tables\ExhibitionsTable;
use App\Models\Exhibition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Exposiciones / Obras';
    protected static ?string $navigationLabel = 'Exposiciones';
    protected static ?string $modelLabel = 'Exposición';
    protected static ?string $pluralModelLabel = 'Exposiciones';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'title';

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

                        \Filament\Forms\Components\RichEditor::make('curatorial_text')
                            ->label('Texto curatorial')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Curaduría y tipo de exposición')
                    ->schema([
                        \Filament\Forms\Components\Select::make('curator_id')
                            ->label('Curador/a')
                            ->relationship('curator', 'name')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('exhibition_type')
                            ->label('Tipo de exposición')
                            ->options([
                                'collective' => 'Colectiva',
                                'individual' => 'Individual',
                                'duo' => 'Dúo',
                                'other' => 'Otra',
                            ])
                            ->default('collective')
                            ->required(),


                        \Filament\Forms\Components\Select::make('people')
                            ->label('Artistas / participantes')
                            ->relationship('people', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('spaces')
                            ->label('Espacios')
                            ->relationship('spaces', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('events')
                            ->label('Eventos relacionados')
                            ->relationship('events', 'title')
                            ->multiple()
                            ->searchable()
                            ->preload(),

                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Fechas')
                    ->schema([
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Fecha de inicio'),

                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha de cierre'),

                        \Filament\Forms\Components\DatePicker::make('opening_date')
                            ->label('Fecha de inauguración'),

                        \Filament\Forms\Components\TimePicker::make('opening_time')
                            ->label('Hora de inauguración')
                            ->seconds(false),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imágenes')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('exhibitions/covers')
                            ->disk('public')->moveFiles(),

                        \Filament\Forms\Components\FileUpload::make('poster_image')
                            ->label('Cartel')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('exhibitions/posters')
                            ->disk('public')->moveFiles(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Publicación y SEO')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'current' => 'Actual',
                                'upcoming' => 'Próxima',
                                'past' => 'Pasada',
                                'archived' => 'Archivada',
                            ])
                            ->default('draft')
                            ->required(),

                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Destacada'),

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
                    ->label('Exposición')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('curator.name')
                    ->label('Curador/a')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('exhibition_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'collective' => 'Colectiva',
                        'individual' => 'Individual',
                        'duo' => 'Dúo',
                        'other' => 'Otra',
                        default => $state,
                    }),

                \Filament\Tables\Columns\TextColumn::make('start_date')
                    ->label('Inicio')
                    ->date('d/m/Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('end_date')
                    ->label('Cierre')
                    ->date('d/m/Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'draft' => 'Borrador',
                        'current' => 'Actual',
                        'upcoming' => 'Próxima',
                        'past' => 'Pasada',
                        'archived' => 'Archivada',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'current' => 'success',
                        'upcoming' => 'info',
                        'past' => 'warning',
                        'archived' => 'gray',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacada')
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
                        'current' => 'Actual',
                        'upcoming' => 'Próxima',
                        'past' => 'Pasada',
                        'archived' => 'Archivada',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('exhibition_type')
                    ->label('Tipo')
                    ->options([
                        'collective' => 'Colectiva',
                        'individual' => 'Individual',
                        'duo' => 'Dúo',
                        'other' => 'Otra',
                    ]),
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
            'index' => ListExhibitions::route('/'),
            'create' => CreateExhibition::route('/create'),
            'edit' => EditExhibition::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
