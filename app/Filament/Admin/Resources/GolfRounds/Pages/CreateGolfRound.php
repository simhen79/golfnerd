<?php

namespace App\Filament\Admin\Resources\GolfRounds\Pages;

use App\Filament\Admin\Resources\GolfRounds\GolfRoundResource;
use App\Services\RankingService;
use Filament\Resources\Pages\CreateRecord;

class CreateGolfRound extends CreateRecord
{
    protected static string $resource = GolfRoundResource::class;

    protected function afterCreate(): void
    {
        $rankingService = app(RankingService::class);

        // Capture the new snapshot after this round
        $rankingService->captureSnapshot();
    }

    protected static bool $canCreateAnother = false;
}
