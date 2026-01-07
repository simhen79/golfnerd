<?php

namespace App\Http\Controllers;

use App\Models\GolfRound;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicStatsController extends Controller
{
    public function index()
    {
        $userStats = User::join('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) as total_rounds'),
                DB::raw('SUM(golf_rounds.eagles) as total_eagles'),
                DB::raw('SUM(golf_rounds.birdies) as total_birdies'),
                DB::raw('SUM(golf_rounds.pars) as total_pars'),
                DB::raw('SUM(golf_rounds.putts) as total_putts'),
                DB::raw('SUM(golf_rounds.bogeys) as total_bogeys'),
                DB::raw('SUM(golf_rounds.double_bogeys_or_worse) as total_double_bogeys'),
                DB::raw('ROUND(SUM(golf_rounds.pars)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 2) as avg_pars_per_round'),
                DB::raw('ROUND(SUM(golf_rounds.birdies)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 2) as avg_birdies_per_round'),
                DB::raw('ROUND(SUM(golf_rounds.eagles)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 2) as avg_eagles_per_round'),
                DB::raw('ROUND(SUM(golf_rounds.putts)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 2) as avg_putts_per_round')
            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_rounds', 'desc')
            ->get();

        $aggregateStats = GolfRound::selectRaw('
                COALESCE(SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 0) as total_rounds,
                SUM(eagles) as total_eagles,
                SUM(birdies) as total_birdies,
                SUM(pars) as total_pars,
                SUM(putts) as total_putts,
                SUM(bogeys) as total_bogeys,
                SUM(double_bogeys_or_worse) as total_double_bogeys,
                ROUND(COALESCE(SUM(birdies), 0)::numeric / NULLIF(SUM(CASE WHEN holes_played = 9 THEN 0.5 ELSE 1 END), 0), 2) as avg_birdies_per_round,
                ROUND(COALESCE(SUM(eagles), 0)::numeric / NULLIF(SUM(CASE WHEN holes_played = 9 THEN 0.5 ELSE 1 END), 0), 2) as avg_eagles_per_round,
                ROUND(COALESCE(SUM(pars), 0)::numeric / NULLIF(SUM(CASE WHEN holes_played = 9 THEN 0.5 ELSE 1 END), 0), 2) as avg_pars_per_round,
                ROUND(COALESCE(SUM(putts), 0)::numeric / NULLIF(SUM(CASE WHEN holes_played = 9 THEN 0.5 ELSE 1 END), 0), 2) as avg_putts_per_round
            ')
            ->first();

        // Top 10 by birdies
        $topBirdies = User::join('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.name',
                DB::raw('COALESCE(SUM(golf_rounds.birdies), 0) as total_birdies')
            )
            ->groupBy('users.id', 'users.name')
            ->havingRaw('COALESCE(SUM(golf_rounds.birdies), 0) > 0')
            ->orderByRaw('COALESCE(SUM(golf_rounds.birdies), 0) DESC')
            ->limit(10)
            ->get();

        // Top 10 by eagles
        $topEagles = User::leftJoin('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.name',
                DB::raw('COALESCE(SUM(golf_rounds.eagles), 0) as total_eagles')
            )
            ->groupBy('users.id', 'users.name')
            ->havingRaw('COALESCE(SUM(golf_rounds.eagles), 0) > 0')
            ->orderByRaw('COALESCE(SUM(golf_rounds.eagles), 0) DESC')
            ->limit(10)
            ->get();

        // Top 10 by rounds
        $topRounds = User::join('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.name',
                DB::raw('COALESCE(SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 0) as total_rounds')
            )
            ->groupBy('users.id', 'users.name')
            ->havingRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) > 0')
            ->orderByRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) DESC')
            ->limit(10)
            ->get();

        // Top 10 least putts (best putting average)
        $leastPutts = User::leftJoin('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.name',
                DB::raw('ROUND(SUM(golf_rounds.putts)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END), 2) as avg_putts_per_round')
            )
            ->groupBy('users.id', 'users.name')
            ->havingRaw('SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) >= 3')
            ->orderByRaw('SUM(golf_rounds.putts)::numeric / SUM(CASE WHEN golf_rounds.holes_played = 9 THEN 0.5 ELSE 1 END) ASC')
            ->limit(10)
            ->get();

        return view('public-stats', compact('userStats', 'aggregateStats', 'topBirdies', 'topEagles', 'topRounds', 'leastPutts'));
    }
}
