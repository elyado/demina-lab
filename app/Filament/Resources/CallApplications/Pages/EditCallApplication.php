<?php

namespace App\Filament\Resources\CallApplications\Pages;

use App\Filament\Resources\CallApplications\CallApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCallApplication extends EditRecord
{
    protected static string $resource = CallApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
