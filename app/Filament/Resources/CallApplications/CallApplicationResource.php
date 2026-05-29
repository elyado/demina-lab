<?php

namespace App\Filament\Resources\CallApplications;

use App\Filament\Resources\CallApplications\Pages\CreateCallApplication;
use App\Filament\Resources\CallApplications\Pages\EditCallApplication;
use App\Filament\Resources\CallApplications\Pages\ListCallApplications;
use App\Filament\Resources\CallApplications\Schemas\CallApplicationForm;
use App\Filament\Resources\CallApplications\Tables\CallApplicationsTable;
use App\Models\CallApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CallApplicationResource extends Resource
{
    protected static ?string $model = CallApplication::class;


    protected static ?string $recordTitleAttribute = 'folio';
    protected static string|\UnitEnum|null $navigationGroup = 'Convocatorias y propuestas';
    protected static ?string $navigationLabel = 'Postulaciones Gatillo';
    protected static ?string $modelLabel = 'postulación';
    protected static ?string $pluralModelLabel = 'postulaciones';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-camera';
    protected static ?int $navigationSort = 3;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Acuse y estado')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('folio')
                            ->label('Folio')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('call_name')
                            ->label('Convocatoria')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'received' => 'Recibida',
                                'reviewing' => 'En revisión',
                                'accepted' => 'Aceptada',
                                'rejected' => 'Rechazada',
                                'archived' => 'Archivada',
                            ])
                            ->required()
                            ->disabled(fn() => auth()->user()?->isJurado())
                            ->dehydrated(fn() => ! auth()->user()?->isJurado()),

                        \Filament\Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('Fecha de recepción')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Datos del postulante')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('age')
                            ->label('Edad')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Correo')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('pseudonym')
                            ->label('Seudónimo')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Datos de obra / serie')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('capture_year')
                            ->label('Año de captura')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('technique_support')
                            ->label('Técnica y soporte')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('dimensions')
                            ->label('Dimensiones')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('edition')
                            ->label('Tiraje')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('production_cost')
                            ->label('Costo de producción')
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\TextInput::make('sale_price')
                            ->label('Valor de venta')
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(false),

                        \Filament\Forms\Components\Textarea::make('intention_note')
                            ->label('Nota de intención')
                            ->rows(4)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('bio')
                            ->label('Semblanza')
                            ->rows(5)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Fotografías enviadas')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('photos_preview')
                            ->label('')
                            ->content(function ($record) {
                                if (! $record) {
                                    return 'Guarda primero la postulación para ver fotografías.';
                                }

                                $record->loadMissing('photos');

                                if ($record->photos->isEmpty()) {
                                    return 'No hay fotografías registradas.';
                                }

                                $html = '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">';

                                foreach ($record->photos as $photo) {
                                    try {
                                        $url = \Illuminate\Support\Facades\Storage::disk('r2')
                                            ->temporaryUrl($photo->file_path, now()->addMinutes(30));
                                    } catch (\Throwable $e) {
                                        $url = null;
                                    }

                                    $html .= '<div style="border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:12px;background:#111;">';

                                    $html .= '<strong style="display:block;margin-bottom:8px;">'
                                        . e($photo->title)
                                        . '</strong>';

                                    if ($url) {
                                        $html .= '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">';
                                        $html .= '<img src="' . e($url) . '" style="width:100%;height:220px;object-fit:cover;border-radius:12px;margin-bottom:8px;">';
                                        $html .= '</a>';
                                        $html .= '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer" style="font-size:13px;color:#93c5fd;">Abrir imagen</a>';
                                    } else {
                                        $html .= '<p style="font-size:13px;color:#aaa;">No se pudo generar vista previa.</p>';
                                        $html .= '<code style="font-size:12px;">' . e($photo->file_path) . '</code>';
                                    }

                                    $html .= '</div>';
                                }

                                $html .= '</div>';

                                return new \Illuminate\Support\HtmlString($html);
                            }),
                    ]),

                \Filament\Schemas\Components\Section::make('Revisión interna')
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('internal_notes')
                            ->label('Notas internas')
                            ->rows(5)
                            ->columnSpanFull()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('pseudonym')
                    ->label('Seudónimo')
                    ->searchable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('photos_count')
                    ->label('Fotos')
                    ->counts('photos')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'received' => 'Recibida',
                        'reviewing' => 'En revisión',
                        'accepted' => 'Aceptada',
                        'rejected' => 'Rechazada',
                        'archived' => 'Archivada',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'received' => 'info',
                        'reviewing' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'archived' => 'gray',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Recibida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'received' => 'Recibida',
                        'reviewing' => 'En revisión',
                        'accepted' => 'Aceptada',
                        'rejected' => 'Rechazada',
                        'archived' => 'Archivada',
                    ]),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()?->isAdmin()),
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
            'index' => ListCallApplications::route('/'),
            'create' => CreateCallApplication::route('/create'),
            'edit' => EditCallApplication::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isJurado();
    }
}
