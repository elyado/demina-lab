<?php

namespace App\Filament\Resources\FilmScreenings\Pages;

use App\Filament\Resources\FilmScreenings\FilmScreeningResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilmScreenings extends ListRecords
{
    protected static string $resource = FilmScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
