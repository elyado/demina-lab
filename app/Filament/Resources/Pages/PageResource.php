<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Filament\Resources\Pages\Schemas\PageForm;
use App\Filament\Resources\Pages\Tables\PagesTable;
use App\Models\Page;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Contenido web';
    protected static ?string $navigationLabel = 'Páginas';
    protected static ?string $modelLabel = 'Página';
    protected static ?string $pluralModelLabel = 'Páginas';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Contenido principal')
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

                        \Filament\Forms\Components\Textarea::make('excerpt')
                            ->label('Extracto')
                            ->rows(3)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\RichEditor::make('body')
                            ->label('Contenido')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Section::make('Imagen y plantilla')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('cover_image')
                            ->label('Imagen de portada')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('pages/covers'),

                        \Filament\Forms\Components\Select::make('template')
                            ->label('Plantilla')
                            ->options([
                                'default' => 'Default',
                                'home' => 'Inicio',
                                'about' => 'Nosotros',
                                'contact' => 'Contacto',
                                'archive' => 'Archivo',
                                'spaces' => 'Espacios',
                            ])
                            ->default('default'),
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
                            ])
                            ->default('draft')
                            ->required(),

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
                    ->label('Página')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('template')
                    ->label('Plantilla')
                    ->badge()
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'default' => 'Default',
                        'home' => 'Inicio',
                        'about' => 'Nosotros',
                        'contact' => 'Contacto',
                        'archive' => 'Archivo',
                        'spaces' => 'Espacios',
                        default => $state ?? 'Sin plantilla',
                    }),

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

                \Filament\Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                    ]),

                \Filament\Tables\Filters\SelectFilter::make('template')
                    ->label('Plantilla')
                    ->options([
                        'default' => 'Default',
                        'home' => 'Inicio',
                        'about' => 'Nosotros',
                        'contact' => 'Contacto',
                        'archive' => 'Archivo',
                        'spaces' => 'Espacios',
                    ]),
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
