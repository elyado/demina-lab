<?php

namespace App\Filament\Resources\SpaceImages\Pages;

use App\Filament\Resources\SpaceImages\SpaceImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpaceImages extends ListRecords
{
    protected static string $resource = SpaceImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
