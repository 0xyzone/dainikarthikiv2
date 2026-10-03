<?php

namespace App\Filament\App\Resources\Credits\Pages;

use App\Filament\App\Resources\Credits\CreditResource;
use App\Filament\App\Resources\Credits\Widgets\CreditOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCredits extends ListRecords
{
    protected static string $resource = CreditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Credit'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreditOverview::class,
        ];
    }
}
