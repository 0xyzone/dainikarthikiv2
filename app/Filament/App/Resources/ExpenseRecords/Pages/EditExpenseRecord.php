<?php

namespace App\Filament\App\Resources\ExpenseRecords\Pages;

use App\Filament\App\Resources\ExpenseRecords\ExpenseRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExpenseRecord extends EditRecord
{
    protected static string $resource = ExpenseRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
