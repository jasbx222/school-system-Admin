<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    public static ?string $title =  'الفواتير';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("إضافة فاتورة"),
        ];
    }
}
