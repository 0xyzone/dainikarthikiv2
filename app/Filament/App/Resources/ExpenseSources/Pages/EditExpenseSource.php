<?php

namespace App\Filament\App\Resources\ExpenseSources\Pages;

use App\Filament\App\Resources\ExpenseSources\ExpenseSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExpenseSource extends EditRecord
{
    protected static string $resource = ExpenseSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
