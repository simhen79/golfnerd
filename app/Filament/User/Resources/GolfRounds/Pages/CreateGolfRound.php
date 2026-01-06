<?php

namespace App\Filament\User\Resources\GolfRounds\Pages;

use App\Filament\User\Resources\GolfRounds\GolfRoundResource;
use App\Models\User;
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
        $stats = $this->getUserStats();
        $message = $this->formatStatsForWhatsApp($stats);

        session()->flash('leaderboard_stats', $stats);
        session()->flash('leaderboard_message', $message);
        session()->flash('show_leaderboard', true);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getUserStats(): array
    {
        return User::select('users.name')
            ->selectRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) as total_rounds')
            ->selectRaw('COALESCE(SUM(golf_rounds.birdies), 0) as total_birdies')
            ->selectRaw('COALESCE(SUM(golf_rounds.eagles), 0) as total_eagles')
            ->selectRaw('COALESCE(SUM(golf_rounds.putts), 0) as total_putts')
            ->leftJoin('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('COUNT(golf_rounds.id) > 0')
            ->orderByRaw('COALESCE(SUM(golf_rounds.birdies), 0) DESC')
            ->orderBy('users.name')
            ->get()
            ->toArray();
    }

    protected function formatStatsForWhatsApp(array $stats): string
    {
        $lines = ['Birdies Leaderboard ' . now()->year . ' 🏌️', ''];

        foreach ($stats as $index => $stat) {
            $position = $index + 1;
            $lines[] = "{$position}. {$stat['name']} - Rounds: {$stat['total_rounds']}, Birdies: {$stat['total_birdies']}, Eagles: {$stat['total_eagles']}, Putts: {$stat['total_putts']}";
        }

        $lines[] = '';
        $lines[] = '➕ Add your round: ' . static::getResource()::getUrl('index');

        return implode("\n", $lines);
    }
}
