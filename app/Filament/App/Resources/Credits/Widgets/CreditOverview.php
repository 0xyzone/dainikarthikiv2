<?php

namespace App\Filament\App\Resources\Credits\Widgets;

use App\Models\Credit;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class CreditOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        $credits = Credit::where('user_id', $userId)
            ->withSum('payments', 'amount')
            ->get();

        $givenCredits = $credits->where('type', 'given');
        $takenCredits = $credits->where('type', 'taken');

        $totalGiven = (float) $givenCredits->sum('amount');
        $givenRemaining = round((float) $givenCredits
            ->where('status', '!=', 'settled')
            ->sum(fn (Credit $credit): float => $credit->remaining_amount), 2);

        $totalTaken = (float) $takenCredits->sum('amount');
        $takenRemaining = round((float) $takenCredits
            ->where('status', '!=', 'settled')
            ->sum(fn (Credit $credit): float => $credit->remaining_amount), 2);

        $netPosition = round($givenRemaining - $takenRemaining, 2);

        return [
            Stat::make('Credit Given (Receivable)', 'Rs. ' . number_format($totalGiven, 2))
                ->description('Rs. ' . number_format($givenRemaining, 2) . ' remaining to collect')
                ->descriptionIcon(Heroicon::OutlinedArrowTrendingUp)
                ->color('success'),

            Stat::make('Credit Taken (Payable)', 'Rs. ' . number_format($totalTaken, 2))
                ->description('Rs. ' . number_format($takenRemaining, 2) . ' remaining to repay')
                ->descriptionIcon(Heroicon::OutlinedArrowTrendingDown)
                ->color('danger'),

            Stat::make('Net Position', ($netPosition >= 0 ? '+' : '') . 'Rs. ' . number_format($netPosition, 2))
                ->description($netPosition >= 0 ? 'Net Receivable' : 'Net Payable')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->color($netPosition >= 0 ? 'success' : 'danger'),
        ];
    }
}
