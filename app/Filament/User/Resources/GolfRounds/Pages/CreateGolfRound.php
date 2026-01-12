<?php

namespace App\Filament\User\Resources\GolfRounds\Pages;

use App\Filament\User\Resources\GolfRounds\GolfRoundResource;
use App\Models\User;
use App\Services\RankingService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGolfRound extends CreateRecord
{
    protected static string $resource = GolfRoundResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $rankingService = app(RankingService::class);

        // Capture the new snapshot after this round
        $rankingService->captureSnapshot();

        $stats = $rankingService->getRankingsWithDeltas();
        $message = $this->formatStatsForWhatsApp($stats);

        session()->flash('leaderboard_stats', $stats->toArray());
        session()->flash('leaderboard_message', $message);
        session()->flash('show_leaderboard', true);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function formatStatsForWhatsApp($stats): string
    {
        $lines = ['Birdies Leaderboard ' . now()->year . ' 🏌️', ''];

        foreach ($stats as $index => $stat) {
            $lines[] = "{$stat['name']} - Rounds: {$stat['total_rounds']}, Birdies: {$stat['total_birdies']}, Avg Putts: {$stat['avg_putts']}";
        }

        $lines[] = '';
        $lines[] = '➕ Add your round: ' . static::getResource()::getUrl('index');

        return implode("\n", $lines);
    }
}
