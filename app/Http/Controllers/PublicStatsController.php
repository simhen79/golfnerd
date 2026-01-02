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
        $userStats = User::leftJoin('golf_rounds', 'users.id', '=', 'golf_rounds.user_id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(golf_rounds.id) as total_rounds'),
                DB::raw('COALESCE(SUM(golf_rounds.eagles), 0) as total_eagles'),
                DB::raw('COALESCE(SUM(golf_rounds.birdies), 0) as total_birdies'),
                DB::raw('COALESCE(SUM(golf_rounds.putts), 0) as total_putts'),
                DB::raw('COALESCE(SUM(golf_rounds.bogeys), 0) as total_bogeys'),
                DB::raw('COALESCE(SUM(golf_rounds.double_bogeys_or_worse), 0) as total_double_bogeys')
            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_rounds', 'desc')
            ->get();

        $aggregateStats = GolfRound::selectRaw('
                COUNT(*) as total_rounds,
                SUM(eagles) as total_eagles,
                SUM(birdies) as total_birdies,
                SUM(putts) as total_putts,
                SUM(bogeys) as total_bogeys,
                SUM(double_bogeys_or_worse) as total_double_bogeys
            ')
            ->first();

        return view('public-stats', compact('userStats', 'aggregateStats'));
    }
}
