<?php

namespace App\Filament\Resources\EntryResource\Pages;

use App\Filament\Resources\EntryResource;
use Filament\Resources\Pages\EditRecord;

class EditEntry extends EditRecord
{
    protected static string $resource = EntryResource::class;

    // إخفاء أزرار الفورم (بما فيهم زر الحفظ)
    protected function getFormActions(): array
    {
        return [];
    }

    // إخفاء أزرار الهيدر مثل الحذف
    protected function getHeaderActions(): array
    {
        return [];
    }

// تغيير عنوان الصفحة من "Edit" إلى "تفاصيل"
public function getTitle(): string
{
    return 'تفاصيل القيد';
}


}
