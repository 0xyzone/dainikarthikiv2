<?php

namespace App\Filament\App\Resources\ExpenseSources\Pages;

use App\Filament\App\Resources\ExpenseSources\ExpenseSourceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseSource extends CreateRecord
{
    protected static string $resource = ExpenseSourceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
