<?php

namespace App\Filament\User\Resources\GolfRounds\Pages;

use App\Filament\User\Resources\GolfRounds\GolfRoundResource;
use App\Models\User;
use App\Services\RankingService;
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
        $rankingService = app(RankingService::class);
        return $rankingService->getRankingsWithDeltas()->toArray();
    }

    protected function formatStatsForWhatsApp(array $stats): string
    {
        $lines = ['Birdies Leaderboard ' . now()->year . ' 🏌️', ''];

        foreach ($stats as $stat) {
            $lines[] = "{$stat['name']} - Rounds: {$stat['total_rounds']}, Birdies: {$stat['total_birdies']}, Avg Putts: {$stat['avg_putts']}";
        }

        $lines[] = '';
        $lines[] = '➕ Add your round: ' . static::getResource()::getUrl('index') . '/create';

        return implode("\n", $lines);
    }
}
