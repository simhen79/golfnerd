<?php

namespace App\Filament\Admin\Resources\GolfCourses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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
