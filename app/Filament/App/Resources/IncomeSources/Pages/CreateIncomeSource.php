<?php

namespace App\Filament\App\Resources\IncomeSources\Pages;

use App\Filament\App\Resources\IncomeSources\IncomeSourceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomeSource extends CreateRecord
{
    protected static string $resource = IncomeSourceResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
