<?php

namespace App\Filament\Admin\Resources\GolfCourses\Pages;

use App\Filament\Admin\Resources\GolfCourses\GolfCourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGolfCourses extends ListRecords
{
    protected static string $resource = GolfCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth('3xl'), // Options: sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, screen
        ];
    }
}
