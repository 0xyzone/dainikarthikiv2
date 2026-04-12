<?php

namespace App\Filament\App\Resources\ExpenseRecords\Pages;

use App\Filament\App\Resources\ExpenseRecords\ExpenseRecordResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseRecord extends CreateRecord
{
    protected static string $resource = ExpenseRecordResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
