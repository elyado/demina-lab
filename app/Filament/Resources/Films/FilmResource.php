<?php

namespace App\Filament\Resources\Films;

use App\Filament\Resources\Films\Pages\CreateFilm;
use App\Filament\Resources\Films\Pages\EditFilm;
use App\Filament\Resources\Films\Pages\ListFilms;
use App\Filament\Resources\Films\Schemas\FilmForm;
use App\Filament\Resources\Films\Tables\FilmsTable;
use App\Models\Film;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilmResource extends Resource
{
    protected static ?string $model = Film::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Programación';
    protected static ?string $navigationLabel = 'Películas';
    protected static ?string $modelLabel = 'Película';
    protected static ?string $pluralModelLabel = 'Películas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información de la película')
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

                        \Filament\Forms\Components\TextInput::make('original_title')
                            ->label('Título original')
                            ->maxLength(220),

                        \Filament\Forms\Components\TextInput::make('director')
                            ->label('Dirección')
                            ->maxLength(180),

                        \Filament\Forms\Components\TextInput::make('country')
                            ->label('País')
                            ->maxLength(120),

                        \Filament\Forms\Components\TextInput::make('release_year')
                            ->label('Año')
                            ->numeric(),

                        \Filament\Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duración en minutos')
                            ->numeric(),

                        \Filament\Forms\Components\TextInput::make('classification')
                            ->label('Clasificación')
                            ->maxLength(50),

                        \Filament\Forms\Components\TextInput::make('genre')
                            ->label('Género')
                            ->maxLength(150),

                        \Filament\Forms\Components\RichEditor::make('synopsis')
                            ->label('Sinopsis')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Material visual')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('trailer_url')
                            ->label('Trailer URL')
                            ->url()
                            ->columnSpanFull(),

                        \Filament\Forms\Components\FileUpload::make('poster_image')
                            ->label('Poster')
                            ->image()
                            ->directory('films/posters'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Película')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('director')
                    ->label('Dirección')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('country')
                    ->label('País')
                    ->searchable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('release_year')
                    ->label('Año')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duración')
                    ->suffix(' min')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('genre')
                    ->label('Género')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([])
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
            'index' => ListFilms::route('/'),
            'create' => CreateFilm::route('/create'),
            'edit' => EditFilm::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
{
    return auth()->user()?->isAdmin() ?? false;
}


    protected static bool $shouldRegisterNavigation = false;
}
