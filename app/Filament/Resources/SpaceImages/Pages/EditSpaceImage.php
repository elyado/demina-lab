<?php

namespace App\Filament\Resources\SpaceImages\Pages;

use App\Filament\Resources\SpaceImages\SpaceImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpaceImage extends EditRecord
{
    protected static string $resource = SpaceImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
