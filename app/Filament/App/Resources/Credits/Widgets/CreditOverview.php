<?php

namespace App\Filament\App\Resources\Credits\Widgets;

use App\Models\Credit;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CreditOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        $credits = Credit::where('user_id', $userId)
            ->withSum('payments', 'amount')
            ->get();

        $givenCredits = $credits->where('type', 'given');
        $takenCredits = $credits->where('type', 'taken');

        $totalGiven = $givenCredits->sum('amount');
        $givenPaid = $givenCredits->sum('payments_sum_amount');
        $givenRemaining = max(0, $totalGiven - $givenPaid);

        $totalTaken = $takenCredits->sum('amount');
        $takenPaid = $takenCredits->sum('payments_sum_amount');
        $takenRemaining = max(0, $totalTaken - $takenPaid);

        $netPosition = $givenRemaining - $takenRemaining;

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
