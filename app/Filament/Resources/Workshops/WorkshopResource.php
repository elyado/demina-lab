<?php

namespace App\Filament\Resources\Workshops;

use App\Filament\Resources\Workshops\Pages\CreateWorkshop;
use App\Filament\Resources\Workshops\Pages\EditWorkshop;
use App\Filament\Resources\Workshops\Pages\ListWorkshops;
use App\Filament\Resources\Workshops\Schemas\WorkshopForm;
use App\Filament\Resources\Workshops\Tables\WorkshopsTable;
use App\Models\Workshop;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkshopResource extends Resource
{
    protected static ?string $model = Workshop::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Programación';
    protected static ?string $navigationLabel = 'Talleres';
    protected static ?string $modelLabel = 'Taller';
    protected static ?string $pluralModelLabel = 'Talleres';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información del taller')
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

                        \Filament\Forms\Components\Select::make('event_id')
                            ->label('Evento relacionado')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\Select::make('facilitator_id')
                            ->label('Tallerista')
                            ->relationship('facilitator', 'name')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('materials')
                            ->label('Materiales')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Costo, cupo y registro')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('cost')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$'),

                        \Filament\Forms\Components\TextInput::make('commission_percentage')
                            ->label('Comisión %')
                            ->numeric()
                            ->suffix('%'),

                        \Filament\Forms\Components\TextInput::make('capacity')
                            ->label('Cupo')
                            ->numeric(),

                        \Filament\Forms\Components\CheckboxList::make('payment_methods')
                            ->label('Métodos de pago')
                            ->options([
                                'cash' => 'Efectivo',
                                'transfer' => 'Transferencia',
                                'online' => 'Pago en línea',
                                'other' => 'Otro',
                            ])
                            ->columns(2),

                        \Filament\Forms\Components\Textarea::make('registration_instructions')
                            ->label('Instrucciones de registro')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Estado')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'draft' => 'Borrador',
                                'published' => 'Publicado',
                                'archived' => 'Archivado',
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
                    ->label('Taller')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('facilitator.name')
                    ->label('Tallerista')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('event.title')
                    ->label('Evento')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('cost')
                    ->label('Costo')
                    ->money('MXN')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('capacity')
                    ->label('Cupo')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
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
            'index' => ListWorkshops::route('/'),
            'create' => CreateWorkshop::route('/create'),
            'edit' => EditWorkshop::route('/{record}/edit'),
        ];
    }
}
