<?php

namespace App\Filament\App\Resources\IncomeSources\Pages;

use App\Filament\App\Resources\IncomeSources\IncomeSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomeSource extends EditRecord
{
    protected static string $resource = IncomeSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
