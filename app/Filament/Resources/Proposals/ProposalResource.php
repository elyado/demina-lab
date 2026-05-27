<?php

namespace App\Filament\Resources\Proposals;

use App\Filament\Resources\Proposals\Pages\CreateProposal;
use App\Filament\Resources\Proposals\Pages\EditProposal;
use App\Filament\Resources\Proposals\Pages\ListProposals;
use App\Filament\Resources\Proposals\Schemas\ProposalForm;
use App\Filament\Resources\Proposals\Tables\ProposalsTable;
use App\Models\Proposal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProposalResource extends Resource
{
    protected static ?string $model = Proposal::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Convocatorias y propuestas';
    protected static ?string $navigationLabel = 'Propuestas';
    protected static ?string $modelLabel = 'Propuesta';
    protected static ?string $pluralModelLabel = 'Propuestas';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Datos de la propuesta')
                    ->schema([
                        \Filament\Forms\Components\Select::make('proposal_type')
                            ->label('Tipo de propuesta')
                            ->options([
                                'exhibition' => 'Exposición',
                                'workshop' => 'Taller',
                                'event' => 'Evento',
                                'space_use' => 'Uso de espacio',
                                'press' => 'Prensa',
                                'collaboration' => 'Colaboración',
                                'other' => 'Otra',
                            ])
                            ->required(),

                        \Filament\Forms\Components\Select::make('call_id')
                            ->label('Convocatoria relacionada')
                            ->relationship('call', 'title')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Título de la propuesta')
                            ->maxLength(220)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Datos de contacto')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(180),

                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->maxLength(180),

                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->maxLength(80),

                        \Filament\Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->maxLength(180),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Preferencias y necesidades')
                    ->schema([
                        \Filament\Forms\Components\Select::make('preferred_space_id')
                            ->label('Espacio preferido')
                            ->relationship('preferredSpace', 'name')
                            ->searchable()
                            ->preload(),

                        \Filament\Forms\Components\DatePicker::make('preferred_date')
                            ->label('Fecha preferida'),

                        \Filament\Forms\Components\TextInput::make('estimated_duration')
                            ->label('Duración estimada')
                            ->maxLength(120),

                        \Filament\Forms\Components\Textarea::make('technical_needs')
                            ->label('Necesidades técnicas')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('budget_description')
                            ->label('Presupuesto / condiciones')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\FileUpload::make('attachment_path')
                            ->label('Archivo adjunto')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('proposals/attachments'),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Seguimiento interno')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'new' => 'Nueva',
                                'reviewing' => 'En revisión',
                                'accepted' => 'Aceptada',
                                'rejected' => 'Rechazada',
                                'archived' => 'Archivada',
                            ])
                            ->default('new')
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('internal_notes')
                            ->label('Notas internas')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Propuesta')
                    ->searchable()
                    ->limit(40)
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('proposal_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'exhibition' => 'Exposición',
                        'workshop' => 'Taller',
                        'event' => 'Evento',
                        'space_use' => 'Uso de espacio',
                        'press' => 'Prensa',
                        'collaboration' => 'Colaboración',
                        'other' => 'Otra',
                        default => $state,
                    }),

                \Filament\Tables\Columns\TextColumn::make('call.title')
                    ->label('Convocatoria')
                    ->limit(30)
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('preferredSpace.name')
                    ->label('Espacio')
                    ->limit(30)
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'new' => 'Nueva',
                        'reviewing' => 'En revisión',
                        'accepted' => 'Aceptada',
                        'rejected' => 'Rechazada',
                        'archived' => 'Archivada',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'info',
                        'reviewing' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'archived' => 'gray',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('proposal_type')
                    ->label('Tipo')
                    ->options([
                        'exhibition' => 'Exposición',
                        'workshop' => 'Taller',
                        'event' => 'Evento',
                        'space_use' => 'Uso de espacio',
                        'press' => 'Prensa',
                        'collaboration' => 'Colaboración',
                        'other' => 'Otra',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'new' => 'Nueva',
                        'reviewing' => 'En revisión',
                        'accepted' => 'Aceptada',
                        'rejected' => 'Rechazada',
                        'archived' => 'Archivada',
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
            'index' => ListProposals::route('/'),
            'create' => CreateProposal::route('/create'),
            'edit' => EditProposal::route('/{record}/edit'),
        ];
    }
}
