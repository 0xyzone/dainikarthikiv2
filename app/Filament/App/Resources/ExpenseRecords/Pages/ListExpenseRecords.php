<?php

namespace App\Filament\App\Resources\ExpenseRecords\Pages;

use App\Filament\App\Resources\ExpenseRecords\ExpenseRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExpenseRecords extends ListRecords
{
    protected static string $resource = ExpenseRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
