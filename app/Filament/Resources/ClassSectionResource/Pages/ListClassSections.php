<?php

namespace App\Filament\Resources\ClassSectionResource\Pages;

use App\Filament\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassSections extends ListRecords
{
    protected static string $resource = ClassSectionResource::class;

    public static ?string $title =  'الشعب';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("إضافة شعبة"),
        ];
    }
}
