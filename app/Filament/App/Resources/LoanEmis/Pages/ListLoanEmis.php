<?php

namespace App\Filament\App\Resources\LoanEmis\Pages;

use App\Filament\App\Resources\LoanEmis\LoanEmiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLoanEmis extends ListRecords
{
    protected static string $resource = LoanEmiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
