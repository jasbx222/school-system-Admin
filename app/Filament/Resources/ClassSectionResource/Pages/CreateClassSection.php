<?php

namespace App\Filament\Resources\ClassSectionResource\Pages;

use App\Filament\Resources\ClassSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassSection extends CreateRecord
{
    protected static string $resource = ClassSectionResource::class;

    public static ?string $title =  'إضافة شعبة';

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = auth()->user()->school_id;
        return $data;
    }
}
