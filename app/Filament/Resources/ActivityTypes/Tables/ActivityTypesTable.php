<?php

namespace App\Filament\Resources\ActivityTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ActivityTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ColorColumn::make('color')
                    ->label('Color'),

                TextColumn::make('icon')
                    ->label('Ícono')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'film' => 'Cine / película',
                        'academic-cap' => 'Taller / formación',
                        'sparkles' => 'Exposición / arte',
                        'musical-note' => 'Música / concierto',
                        'microphone' => 'Charla / presentación',
                        'users' => 'Comunidad / encuentro',
                        'beaker' => 'Laboratorio / experimentación',
                        'paint-brush' => 'Artes visuales',
                        'book-open' => 'Lectura / publicación',
                        'calendar-days' => 'Actividad general',
                        default => '—',
                    }),

                IconColumn::make('is_recurring')
                    ->label('Recurrente')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_recurring')
                    ->label('Actividad recurrente'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}