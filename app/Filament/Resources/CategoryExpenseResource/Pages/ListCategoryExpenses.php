<?php

namespace App\Filament\Resources\CategoryExpenseResource\Pages;

use App\Filament\Resources\CategoryExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryExpenses extends ListRecords
{
    protected static string $resource = CategoryExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
