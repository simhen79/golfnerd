<?php

namespace App\Filament\Resources\GolfRounds\Pages;

use App\Filament\Resources\GolfRounds\GolfRoundResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGolfRounds extends ListRecords
{
    protected static string $resource = GolfRoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Round'),
        ];
    }
}
