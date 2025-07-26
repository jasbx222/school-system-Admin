<?php

namespace App\Filament\Resources\ClassRoomResource\Pages;

use App\Filament\Resources\ClassRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassRooms extends ListRecords
{
    protected static string $resource = ClassRoomResource::class;

    public static ?string $title =  'الصفوف';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("إضافة صف"),
        ];
    }
}
