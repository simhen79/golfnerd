<?php

namespace App\Filament\Resources\GolfRounds\Schemas;

use App\Models\GolfCourse;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GolfRoundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Round Details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->preload(),
                        DatePicker::make('date_played')
                            ->label('Date Played')
                            ->required()
                            ->maxDate(now())
                            ->native(false),
                        Select::make('golf_course_id')
                            ->label('Golf Course')
                            ->options(GolfCourse::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->preload(),
                    ])
                    ->columns(3),
                Section::make('Scoring')
                    ->schema([
                        TextInput::make('eagles')
                            ->label('Eagles')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),
                        TextInput::make('birdies')
                            ->label('Birdies')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),
                        TextInput::make('pars')
                            ->label('Pars')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('putts')
                            ->label('Total Putts')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('bogeys')
                            ->label('Bogeys')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('double_bogeys_or_worse')
                            ->label('Double Bogeys or Worse')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('score')
                            ->label('Total Score')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->columns(3),
            ]);
    }
}
