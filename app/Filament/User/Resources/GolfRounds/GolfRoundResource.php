<?php

namespace App\Filament\User\Resources\GolfRounds;

use App\Filament\User\Resources\GolfRounds\Pages\CreateGolfRound;
use App\Filament\User\Resources\GolfRounds\Pages\EditGolfRound;
use App\Filament\User\Resources\GolfRounds\Pages\ListGolfRounds;
use App\Filament\User\Resources\GolfRounds\Schemas\GolfRoundForm;
use App\Filament\User\Resources\GolfRounds\Tables\GolfRoundsTable;
use App\Models\GolfRound;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GolfRoundResource extends Resource
{
    protected static ?string $model = GolfRound::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'My Golf Rounds';

    protected static ?string $modelLabel = 'Golf Round';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return GolfRoundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GolfRoundsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGolfRounds::route('/'),
            'create' => CreateGolfRound::route('/create'),
            'edit' => EditGolfRound::route('/{record}/edit'),
        ];
    }
}
