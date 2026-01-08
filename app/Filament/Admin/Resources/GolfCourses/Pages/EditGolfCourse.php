<?php

namespace App\Filament\Admin\Resources\GolfCourses\Pages;

use App\Filament\Admin\Resources\GolfCourses\GolfCourseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGolfCourse extends EditRecord
{
    protected static string $resource = GolfCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
