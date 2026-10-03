<?php

namespace App\Filament\App\Resources\LoanEmis\Pages;

use App\Filament\App\Resources\LoanEmis\LoanEmiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLoanEmi extends ViewRecord
{
    protected static string $resource = LoanEmiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
