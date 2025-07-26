<?php

namespace App\Filament\Resources\ClassroomSemesterResource\Pages;

use App\Filament\Resources\ClassroomSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassroomSemester extends CreateRecord
{
    protected static string $resource = ClassroomSemesterResource::class;

    public static ?string $title =  'إضافة تكلفة';

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
