<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    public static ?string $title =  'الخصومات';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("إضافة خصم"),
        ];
    }
}
