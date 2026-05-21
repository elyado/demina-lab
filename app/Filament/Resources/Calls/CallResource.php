<?php

namespace App\Filament\Resources\Calls;

use App\Filament\Resources\Calls\Pages\CreateCall;
use App\Filament\Resources\Calls\Pages\EditCall;
use App\Filament\Resources\Calls\Pages\ListCalls;
use App\Filament\Resources\Calls\Schemas\CallForm;
use App\Filament\Resources\Calls\Tables\CallsTable;
use App\Models\Call;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CallResource extends Resource
{
    protected static ?string $model = Call::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Convocatorias y propuestas';
    protected static ?string $navigationLabel = 'Convocatorias';
    protected static ?string $modelLabel = 'Convocatoria';
    protected static ?string $pluralModelLabel = 'Convocatorias';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información de la convocatoria')
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

                        \Filament\Forms\Components\Select::make('call_type')
                            ->label('Tipo')
                            ->options([
                                'exhibition' => 'Exposición',
                                'workshop' => 'Taller',
                                'event' => 'Evento',
                                'residency' => 'Residencia',
                                'collaboration' => 'Colaboración',
                                'press' => 'Prensa',
                                'general' => 'General',
                            ])
                            ->default('general')
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('short_description')
                            ->label('Descripción corta')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción completa')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('requirements')
                            ->label('Requisitos')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Fechas y formulario')
                    ->schema([
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Fecha de inicio'),

                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha de cierre'),

                        \Filament\Forms\Components\TextInput::make('form_url')
                            ->label('URL del formulario')
                            ->url()
                            ->columnSpanFull(),

                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('calls/covers'),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Estado')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'open' => 'Abierta',
                                'closed' => 'Cerrada',
                                'archived' => 'Archivada',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Convocatoria')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('call_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'exhibition' => 'Exposición',
                        'workshop' => 'Taller',
                        'event' => 'Evento',
                        'residency' => 'Residencia',
                        'collaboration' => 'Colaboración',
                        'press' => 'Prensa',
                        'general' => 'General',
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
                        'open' => 'Abierta',
                        'closed' => 'Cerrada',
                        'archived' => 'Archivada',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'open' => 'success',
                        'closed' => 'warning',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'open' => 'Abierta',
                        'closed' => 'Cerrada',
                        'archived' => 'Archivada',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('call_type')
                    ->label('Tipo')
                    ->options([
                        'exhibition' => 'Exposición',
                        'workshop' => 'Taller',
                        'event' => 'Evento',
                        'residency' => 'Residencia',
                        'collaboration' => 'Colaboración',
                        'press' => 'Prensa',
                        'general' => 'General',
                    ]),
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
            'index' => ListCalls::route('/'),
            'create' => CreateCall::route('/create'),
            'edit' => EditCall::route('/{record}/edit'),
        ];
    }
}
