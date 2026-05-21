<?php

namespace App\Filament\Resources\SpaceImages;

use App\Filament\Resources\SpaceImages\Pages\CreateSpaceImage;
use App\Filament\Resources\SpaceImages\Pages\EditSpaceImage;
use App\Filament\Resources\SpaceImages\Pages\ListSpaceImages;
use App\Filament\Resources\SpaceImages\Schemas\SpaceImageForm;
use App\Filament\Resources\SpaceImages\Tables\SpaceImagesTable;
use App\Models\SpaceImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SpaceImageResource extends Resource
{
    protected static ?string $model = SpaceImage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Espacios';

    protected static ?string $navigationLabel = 'Imágenes de espacios';

    protected static ?string $modelLabel = 'imagen de espacio';

    protected static ?string $pluralModelLabel = 'imágenes de espacios';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SpaceImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpaceImagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpaceImages::route('/'),
            'create' => CreateSpaceImage::route('/create'),
            'edit' => EditSpaceImage::route('/{record}/edit'),
        ];
    }
}