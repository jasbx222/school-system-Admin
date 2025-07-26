<?php

namespace App\Filament\Resources\ClassroomSemesterResource\Pages;

use App\Filament\Resources\ClassroomSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassroomSemesters extends ListRecords
{
    protected static string $resource = ClassroomSemesterResource::class;

    public static ?string $title =  'التكاليف';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("إضافة تكلفة"),
        ];
    }
}
