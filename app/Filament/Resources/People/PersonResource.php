<?php

namespace App\Filament\Resources\People;

use App\Filament\Resources\People\Pages\CreatePerson;
use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Filament\Resources\People\Tables\PeopleTable;
use App\Models\Person;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Comunidad';
    protected static ?string $navigationLabel = 'Personas';
    protected static ?string $modelLabel = 'Persona';
    protected static ?string $pluralModelLabel = 'Personas';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name ';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información general')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(200),

                        \Filament\Forms\Components\Select::make('role_type')
                            ->label('Tipo de perfil')
                            ->options([
                                'artist' => 'Artista',
                                'curator' => 'Curador/a',
                                'workshop_facilitator' => 'Tallerista',
                                'musician' => 'Músico/a',
                                'speaker' => 'Ponente',
                                'performer' => 'Performer',
                                'team' => 'Equipo',
                                'collaborator' => 'Colaborador/a',
                                'other' => 'Otro',
                            ])
                            ->default('artist')
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('short_bio')
                            ->label('Bio corta')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('bio')
                            ->label('Biografía completa')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Contacto y redes')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->maxLength(150),

                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->maxLength(80),

                        \Filament\Forms\Components\TextInput::make('website_url')
                            ->label('Sitio web')
                            ->url(),

                        \Filament\Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url(),

                        \Filament\Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imagen y visibilidad')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('portrait_image')
                            ->label('Retrato / imagen')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('people/portraits'),

                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Destacado'),

                        \Filament\Forms\Components\Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
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
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('role_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'artist' => 'Artista',
                        'curator' => 'Curador/a',
                        'workshop_facilitator' => 'Tallerista',
                        'musician' => 'Músico/a',
                        'speaker' => 'Ponente',
                        'performer' => 'Performer',
                        'team' => 'Equipo',
                        'collaborator' => 'Colaborador/a',
                        'other' => 'Otro',
                        default => $state,
                    }),

                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('instagram_url')
                    ->label('Instagram')
                    ->limit(30)
                    ->toggleable(),

                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),

                \Filament\Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('role_type')
                    ->label('Tipo de perfil')
                    ->options([
                        'artist' => 'Artista',
                        'curator' => 'Curador/a',
                        'workshop_facilitator' => 'Tallerista',
                        'musician' => 'Músico/a',
                        'speaker' => 'Ponente',
                        'performer' => 'Performer',
                        'team' => 'Equipo',
                        'collaborator' => 'Colaborador/a',
                        'other' => 'Otro',
                    ]),

                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo'),

                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destacado'),
            ])
            ->defaultSort('name')
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
            'index' => ListPeople::route('/'),
            'create' => CreatePerson::route('/create'),
            'edit' => EditPerson::route('/{record}/edit'),
        ];
    }
}
