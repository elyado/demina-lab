<?php

namespace App\Filament\Resources\Cineclubs\Pages;

use App\Filament\Resources\Cineclubs\CineclubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCineclubs extends ListRecords
{
    protected static string $resource = CineclubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
