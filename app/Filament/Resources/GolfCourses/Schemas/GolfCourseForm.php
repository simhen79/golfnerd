<?php

namespace App\Filament\Resources\GolfCourses\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class GolfCourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Golf Course Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Course Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Fancourt Links'),
                        TextInput::make('city')
                            ->label('City')
                            ->maxLength(255)
                            ->placeholder('e.g., George'),
                        TextInput::make('province')
                            ->label('Province')
                            ->maxLength(255)
                            ->placeholder('e.g., Western Cape'),
                    ])
            ])->columns(1);
    }
}
