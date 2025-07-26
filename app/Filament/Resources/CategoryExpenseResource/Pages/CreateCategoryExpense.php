<?php

namespace App\Filament\Resources\CategoryExpenseResource\Pages;

use App\Filament\Resources\CategoryExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryExpense extends CreateRecord
{
    protected static string $resource = CategoryExpenseResource::class;
}
