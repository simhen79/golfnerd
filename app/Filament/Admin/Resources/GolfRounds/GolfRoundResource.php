<?php

namespace App\Filament\Admin\Resources\GolfRounds;

use App\Filament\Admin\Resources\GolfRounds\Pages\CreateGolfRound;
use App\Filament\Admin\Resources\GolfRounds\Pages\EditGolfRound;
use App\Filament\Admin\Resources\GolfRounds\Pages\ListGolfRounds;
use App\Filament\Admin\Resources\GolfRounds\Tables\GolfRoundsTable;
use App\Filament\User\Resources\GolfRounds\Schemas\GolfRoundForm;
use App\Models\GolfRound;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GolfRoundResource extends Resource
{
    protected static ?string $model = GolfRound::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string $resource = GolfRoundResource::class;

    public static function form(Schema $schema): Schema
    {
        return GolfRoundForm::configure($schema, isAdmin: true);
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
