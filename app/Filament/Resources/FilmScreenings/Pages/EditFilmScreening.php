<?php

namespace App\Filament\Resources\FilmScreenings\Pages;

use App\Filament\Resources\FilmScreenings\FilmScreeningResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilmScreening extends EditRecord
{
    protected static string $resource = FilmScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
