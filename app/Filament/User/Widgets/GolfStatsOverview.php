<?php

namespace App\Filament\User\Widgets;

use App\Models\GolfRound;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class GolfStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        $stats = GolfRound::where('user_id', $user->id)
            ->selectRaw('
                SUM(CASE WHEN holes_played = 9 THEN 0.5 ELSE 1 END) as total_rounds,
                SUM(eagles) as total_eagles,
                SUM(birdies) as total_birdies,
                SUM(pars) as total_pars,
                SUM(putts) as total_putts,
                SUM(bogeys) as total_bogeys,
                SUM(double_bogeys_or_worse) as total_double_bogeys
            ')
            ->first();

        return [
            Stat::make('Total Rounds', $stats->total_rounds ?? 0)
                ->description('Rounds played')
                ->descriptionIcon('heroicon-m-flag')
                ->color('success'),
            Stat::make('Eagles', $stats->total_eagles ?? 0)
                ->description('Total eagles scored')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Birdies', $stats->total_birdies ?? 0)
                ->description('Total birdies scored')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),
            Stat::make('Pars', $stats->total_pars ?? 0)
                ->description('Total pars scored')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),
            Stat::make('Total Putts', $stats->total_putts ?? 0)
                ->description('All putts')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('gray'),
            Stat::make('Bogeys', $stats->total_bogeys ?? 0)
                ->description('Total bogeys')
                ->descriptionIcon('heroicon-m-minus-circle')
                ->color('warning'),
            Stat::make('Double Bogeys+', $stats->total_double_bogeys ?? 0)
                ->description('Double bogeys or worse')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
