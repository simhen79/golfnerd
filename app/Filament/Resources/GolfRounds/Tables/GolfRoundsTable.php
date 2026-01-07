<?php

namespace App\Filament\Resources\GolfRounds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GolfRoundsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_played')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('golfCourse.name')
                    ->label('Golf Course')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('eagles')
                    ->label('Eagles')
                    ->sortable(),
                TextColumn::make('birdies')
                    ->label('Birdies')
                    ->sortable(),
                TextColumn::make('pars')
                    ->label('Pars')
                    ->sortable(),
                TextColumn::make('putts')
                    ->label('Putts')
                    ->sortable(),
                TextColumn::make('bogeys')
                    ->label('Bogeys')
                    ->sortable(),
                TextColumn::make('double_bogeys_or_worse')
                    ->label('Double Bogeys+')
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->default('-'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date_played', 'desc');
    }
}
