<?php

namespace App\Filament\App\Resources\ExpenseSources\Pages;

use App\Filament\App\Resources\ExpenseSources\ExpenseSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExpenseSources extends ListRecords
{
    protected static string $resource = ExpenseSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
