<?php

namespace App\Filament\Resources\CategoryExpenseResource\Pages;

use App\Filament\Resources\CategoryExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryExpense extends EditRecord
{
    protected static string $resource = CategoryExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
