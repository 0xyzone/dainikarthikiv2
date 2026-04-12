<?php

namespace App\Filament\App\Resources\IncomeSources\Pages;

use App\Filament\App\Resources\IncomeSources\IncomeSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIncomeSources extends ListRecords
{
    protected static string $resource = IncomeSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
