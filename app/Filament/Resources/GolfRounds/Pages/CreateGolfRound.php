<?php

namespace App\Filament\Resources\GolfRounds\Pages;

use App\Filament\Resources\GolfRounds\GolfRoundResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGolfRound extends CreateRecord
{
    protected static string $resource = GolfRoundResource::class;

    protected function afterCreate(mixed $record, ?string $redirectUrl = null): ?string
    {

    }
}
