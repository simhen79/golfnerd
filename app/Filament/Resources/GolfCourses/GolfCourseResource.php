<?php

namespace App\Filament\Resources\GolfCourses;

use App\Filament\Resources\GolfCourses\Pages\CreateGolfCourse;
use App\Filament\Resources\GolfCourses\Pages\EditGolfCourse;
use App\Filament\Resources\GolfCourses\Pages\ListGolfCourses;
use App\Filament\Resources\GolfCourses\Schemas\GolfCourseForm;
use App\Filament\Resources\GolfCourses\Tables\GolfCoursesTable;
use App\Models\GolfCourse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GolfCourseResource extends Resource
{
    protected static ?string $model = GolfCourse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Golf Courses';

    protected static ?string $modelLabel = 'Golf Course';

    protected static ?string $pluralModelLabel = 'Golf Courses';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return GolfCourseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GolfCoursesTable::configure($table);
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
            'index' => ListGolfCourses::route('/')
        ];
    }
}
