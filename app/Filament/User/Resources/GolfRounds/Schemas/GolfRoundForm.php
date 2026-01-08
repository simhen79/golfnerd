<?php

namespace App\Filament\User\Resources\GolfRounds\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\GolfCourse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GolfRoundForm
{
    public static function configure(Schema $schema, bool $isAdmin = false): Schema
    {
        $roundDetailsFields = [];

        if ($isAdmin) {
            $roundDetailsFields[] = Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->preload();
        }

        $roundDetailsFields = array_merge($roundDetailsFields, [
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
            Select::make('holes_played')
                ->label('Holes Played')
                ->options([
                    9 => '9 Holes',
                    18 => '18 Holes',
                ])
                ->default(18)
                ->required()
                ->reactive(),
        ]);

        return $schema
            ->components([
                Section::make('Round Details')
                    ->schema($roundDetailsFields)
                    ->columns(1),
                Section::make('Scoring')
                    ->schema([
                        TextInput::make('eagles')
                            ->label('Eagles')
                            ->numeric()
                            ->default(0)
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            })
                            ->required(),
                        TextInput::make('birdies')
                            ->label('Birdies')
                            ->numeric()
                            ->default(0)
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            })
                            ->required(),
                        TextInput::make('pars')
                            ->label('Pars')
                            ->numeric()
                            ->default(0)
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            }),
                        TextInput::make('bogeys')
                            ->label('Bogeys')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            }),
                        TextInput::make('double_bogeys_or_worse')
                            ->label('Double Bogeys (or worse)')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            }),
                        TextInput::make('putts')
                            ->label('Total Putts')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->rules(function ($get) {
                                $holesPlayed = $get('holes_played') ?? 18;
                                return ['numeric', 'required', 'min:0', "max:{$holesPlayed}"];
                            }),
                        TextInput::make('score')
                            ->label('Total Score (Optional)')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->columns(2),
            ])
            ->columns(2);
    }
}
