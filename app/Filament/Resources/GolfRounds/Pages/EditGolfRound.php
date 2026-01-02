<?php

namespace App\Filament\Resources\GolfRounds\Pages;

use App\Filament\Resources\GolfRounds\GolfRoundResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGolfRound extends EditRecord
{
    protected static string $resource = GolfRoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
