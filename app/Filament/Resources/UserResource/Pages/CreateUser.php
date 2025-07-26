<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
 
    if (empty($data['expires_at'])) {
        $data['expires_at'] = now()->addDays(30); 
    } else {
        $data['expires_at'] = \Carbon\Carbon::parse($data['expires_at']);
    }

    return $data;
}

}
