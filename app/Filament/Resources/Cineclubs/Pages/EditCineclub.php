<?php

namespace App\Filament\Resources\Cineclubs\Pages;

use App\Filament\Resources\Cineclubs\CineclubResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCineclub extends EditRecord
{
    protected static string $resource = CineclubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
