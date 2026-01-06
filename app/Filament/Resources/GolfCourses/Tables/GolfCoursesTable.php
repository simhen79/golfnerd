<?php

namespace App\Filament\Resources\GolfCourses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GolfCoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Course Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable()
                    ->default('N/A'),
                TextColumn::make('province')
                    ->label('Province')
                    ->searchable()
                    ->sortable()
                    ->default('N/A'),
                TextColumn::make('golfRounds_count')
                    ->label('Rounds Played')
                    ->counts('golfRounds')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->modalWidth('3xl'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
