<?php

namespace App\Filament\Resources\ClassroomSemesterResource\Pages;

use App\Filament\Resources\ClassroomSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassroomSemester extends EditRecord
{
    protected static string $resource = ClassroomSemesterResource::class;

    public static ?string $title =  'تعديل تكلفة';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
