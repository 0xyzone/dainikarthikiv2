<?php

namespace App\Filament\App\Resources\IncomeRecords\Pages;

use App\Filament\App\Resources\IncomeRecords\IncomeRecordResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomeRecord extends CreateRecord
{
    protected static string $resource = IncomeRecordResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
