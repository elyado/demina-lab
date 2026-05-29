<?php

namespace App\Filament\Resources\CallApplications\Pages;

use App\Filament\Resources\CallApplications\CallApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCallApplications extends ListRecords
{
    protected static string $resource = CallApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
