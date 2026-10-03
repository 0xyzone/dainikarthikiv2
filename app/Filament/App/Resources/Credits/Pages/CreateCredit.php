<?php

namespace App\Filament\App\Resources\Credits\Pages;

use App\Filament\App\Resources\Credits\CreditResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCredit extends CreateRecord
{
    protected static string $resource = CreditResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
