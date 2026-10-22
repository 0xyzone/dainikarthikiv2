<?php

namespace App\Filament\App\Resources\LoanEmis\Pages;

use App\Filament\App\Resources\LoanEmis\LoanEmiResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLoanEmi extends CreateRecord
{
    protected static string $resource = LoanEmiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
