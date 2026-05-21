<?php

namespace App\Filament\Resources\FilmScreenings;

use App\Filament\Resources\FilmScreenings\Pages\CreateFilmScreening;
use App\Filament\Resources\FilmScreenings\Pages\EditFilmScreening;
use App\Filament\Resources\FilmScreenings\Pages\ListFilmScreenings;
use App\Filament\Resources\FilmScreenings\Schemas\FilmScreeningForm;
use App\Filament\Resources\FilmScreenings\Tables\FilmScreeningsTable;
use App\Models\FilmScreening;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FilmScreeningResource extends Resource
{
    protected static ?string $model = FilmScreening::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Programación';
    protected static ?string $navigationLabel = 'Funciones de cine';
    protected static ?string $modelLabel = 'Función de cine';
    protected static ?string $pluralModelLabel = 'Funciones de cine';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Función de cine')
                    ->schema([
                        \Filament\Forms\Components\Select::make('event_id')
                            ->label('Evento relacionado')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        \Filament\Forms\Components\Select::make('film_id')
                            ->label('Película')
                            ->relationship('film', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('notes')
                            ->label('Notas')
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
                \Filament\Tables\Columns\TextColumn::make('film.title')
                    ->label('Película')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('event.title')
                    ->label('Evento')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('event.start_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('event.start_time')
                    ->label('Hora')
                    ->time('H:i')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(40)
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
            'index' => ListFilmScreenings::route('/'),
            'create' => CreateFilmScreening::route('/create'),
            'edit' => EditFilmScreening::route('/{record}/edit'),
        ];
    }


    protected static bool $shouldRegisterNavigation = false;
}
