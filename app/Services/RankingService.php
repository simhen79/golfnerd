<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRankingSnapshot;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RankingService
{
    public function getCurrentRankings(): Collection
    {
        return User::select('users.id', 'users.name')
            ->selectRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) as total_rounds')
            ->selectRaw('COALESCE(SUM(golf_rounds.birdies), 0) as total_birdies')
            ->selectRaw('COALESCE(SUM(golf_rounds.eagles), 0) as total_eagles')
            ->selectRaw('COALESCE(SUM(golf_rounds.putts), 0) as total_putts')
            ->leftJoin('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('COUNT(golf_rounds.id) > 0')
            ->orderByRaw('COALESCE(SUM(golf_rounds.birdies), 0) DESC')
            ->orderByRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) DESC')
            ->orderBy('users.name')
            ->get()
            ->map(function ($user, $index) {
                $user->ranking_position = $index + 1;
                return $user;
            });
    }

    public function captureSnapshot(): void
    {
        $rankings = $this->getCurrentRankings();
        $now = now();

        foreach ($rankings as $ranking) {
            UserRankingSnapshot::create([
                'user_id' => $ranking->id,
                'ranking_position' => $ranking->ranking_position,
                'total_birdies' => $ranking->total_birdies,
                'total_rounds' => $ranking->total_rounds,
                'snapshot_at' => $now,
            ]);
        }
    }

    public function getRankingsWithDeltas(): Collection
    {
        $currentRankings = $this->getCurrentRankings();

        // Get the second-to-last snapshot for each user (not the most recent one)
        $previousSnapshots = UserRankingSnapshot::select('user_id', 'ranking_position', 'snapshot_at')
            ->whereIn('user_id', $currentRankings->pluck('id'))
            ->whereRaw('snapshot_at < (
                SELECT MAX(snapshot_at)
                FROM user_ranking_snapshots AS urs2
                WHERE urs2.user_id = user_ranking_snapshots.user_id
            )')
            ->orderBy('snapshot_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function ($snapshots) {
                return $snapshots->first(); // Get the most recent snapshot before the latest
            })
            ->keyBy('user_id');

        return $currentRankings->map(function ($ranking) use ($previousSnapshots) {
            $previousSnapshot = $previousSnapshots->get($ranking->id);

            if ($previousSnapshot) {
                $delta = $previousSnapshot->ranking_position - $ranking->ranking_position;
                $ranking->delta = $delta;
                $ranking->previous_position = $previousSnapshot->ranking_position;
            } else {
                $ranking->delta = 0;
                $ranking->previous_position = null;
            }

            return $ranking;
        });
    }

    public function formatDelta(?int $delta): string
    {
        if ($delta === null || $delta === 0) {
            return '—';
        }

        if ($delta > 0) {
            return '↑ ' . $delta;
        }

        return '↓ ' . abs($delta);
    }
}
