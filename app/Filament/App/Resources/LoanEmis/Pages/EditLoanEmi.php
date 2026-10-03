<?php

namespace App\Filament\App\Resources\LoanEmis\Pages;

use App\Filament\App\Resources\LoanEmis\LoanEmiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLoanEmi extends EditRecord
{
    protected static string $resource = LoanEmiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
