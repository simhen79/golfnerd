<?php

namespace App\Filament\User\Resources\GolfRounds\Pages;

use App\Filament\User\Resources\GolfRounds\GolfRoundResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ListGolfRounds extends ListRecords
{
    protected static string $resource = GolfRoundResource::class;

    public function mount(): void
    {
        parent::mount();

        if (session()->has('show_leaderboard')) {
            session()->forget('show_leaderboard');
            $this->js('setTimeout(() => $wire.mountAction("showStats"), 100)');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->showStatsAction()
                ->color('success'),
            CreateAction::make()
                ->label('Add Round')
                ->slideOver()
                ->modalHeading('Add Round')
                ->modalSubmitActionLabel('Add Round')
                ->createAnother(false)
                ->using(function (array $data) {
                    $data['user_id'] = Auth::id();
                    return static::getResource()::getModel()::create($data);
                })
                ->successNotification(
                    fn () => Notification::make()
                        ->title('Round saved successfully!')
                        ->success()
                )
                ->after(function () {
                    $this->js('setTimeout(() => $wire.mountAction("showStats"), 300)');
                }),
        ];
    }

    #[On('open-stats-modal')]
    public function openStatsModal(): void
    {
        $this->mountAction('showStats');
    }

    public function showStatsAction(): Action
    {
        return Action::make('showStats')
            ->label('View Leaderboard')
            ->icon('heroicon-o-trophy')
            ->modalHeading('🏌️ Birdies Leaderboard')
            ->modalWidth('2xl')
            ->modalContent(function () {
                if (session()->has('leaderboard_stats') && session()->has('leaderboard_message')) {
                    $stats = session('leaderboard_stats');
                    $message = session('leaderboard_message');
                    session()->forget(['leaderboard_stats', 'leaderboard_message']);
                } else {
                    $stats = $this->getFormattedStats();
                    $message = $this->formatStatsForWhatsApp($stats);
                }

                return view('filament.modals.stats-modal', [
                    'stats' => $stats,
                    'message' => $message,
                ]);
            })
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close');
    }

    protected function getFormattedStats(): array
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
            $lines[] = "{$position}. {$stat['name']} - Rounds: {$stat['total_rounds']}, Birdies: {$stat['total_birdies']}, Eagles: {$stat['total_eagles']},  Putts: {$stat['total_putts']}";
        }

        $lines[] = '';
        $lines[] = '➕ Add your round: ' . static::getResource()::getUrl('index') . '/create';

        return implode("\n", $lines);
    }
}
