<?php

namespace App\Filament\User\Resources\GolfRounds\Pages;

use App\Filament\User\Resources\GolfRounds\GolfRoundResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGolfRound extends CreateRecord
{
    protected static string $resource = GolfRoundResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
