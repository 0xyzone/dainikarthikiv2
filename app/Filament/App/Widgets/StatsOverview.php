<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();

        if (! $user) {
            return [];
        }

        $now = now();
        $lastMonth = now()->subMonth();

        $thisMonthIncome = (float) $user->incomeRecords()
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');

        $lastMonthIncome = (float) $user->incomeRecords()
            ->whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->sum('amount');

        $thisMonthExpenses = (float) $user->expenseRecords()
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');

        $lastMonthExpenses = (float) $user->expenseRecords()
            ->whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->sum('amount');

        $thisMonthNet = $thisMonthIncome - $thisMonthExpenses;

        $calcChange = function (float $current, float $previous): array {
            if ($previous > 0) {
                $pct = (($current - $previous) / $previous) * 100;
                $formatted = ($pct >= 0 ? '+' : '') . number_format($pct, 1) . '% vs last month';
                $icon = $pct >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
                return [$formatted, $icon];
            }
            if ($current > 0) {
                return ['+100% vs last month', 'heroicon-m-arrow-trending-up'];
            }
            return ['No prior activity', null];
        };

        [$incomeDesc, $incomeIcon] = $calcChange($thisMonthIncome, $lastMonthIncome);
        [$expenseDesc, $expenseIcon] = $calcChange($thisMonthExpenses, $lastMonthExpenses);

        // Credits & Debts
        $credits = $user->credits()
            ->withSum('payments', 'amount')
            ->get();

        $givenCredits = $credits->where('type', 'given');
        $takenCredits = $credits->where('type', 'taken');

        $givenTotal = (float) $givenCredits->sum('amount');
        $givenPaid = (float) $givenCredits->sum('payments_sum_amount');
        $givenRemaining = max(0, $givenTotal - $givenPaid);

        $takenTotal = (float) $takenCredits->sum('amount');
        $takenPaid = (float) $takenCredits->sum('payments_sum_amount');
        $takenRemaining = max(0, $takenTotal - $takenPaid);

        $activeGivenCount = $givenCredits->where('status', '!=', 'settled')->count();
        $activeTakenCount = $takenCredits->where('status', '!=', 'settled')->count();

        // 6-month sparkline
        $incomeSparkline = [];
        $expenseSparkline = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $incomeSparkline[] = (float) $user->incomeRecords()
                ->whereYear('date', $m->year)
                ->whereMonth('date', $m->month)
                ->sum('amount');
            $expenseSparkline[] = (float) $user->expenseRecords()
                ->whereYear('date', $m->year)
                ->whereMonth('date', $m->month)
                ->sum('amount');
        }

        return [
            Stat::make('Total Income (This Month)', 'रु ' . number_format($thisMonthIncome, 2))
                ->description($incomeDesc)
                ->descriptionIcon($incomeIcon)
                ->color('success')
                ->chart($incomeSparkline),

            Stat::make('Total Expenses (This Month)', 'रु ' . number_format($thisMonthExpenses, 2))
                ->description($expenseDesc)
                ->descriptionIcon($expenseIcon)
                ->color('danger')
                ->chart($expenseSparkline),

            Stat::make('Net Balance (This Month)', ($thisMonthNet >= 0 ? '+' : '') . 'रु ' . number_format($thisMonthNet, 2))
                ->description($thisMonthNet >= 0 ? 'Surplus cash flow' : 'Deficit cash flow')
                ->descriptionIcon($thisMonthNet >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($thisMonthNet >= 0 ? 'success' : 'danger'),

            Stat::make('Credits (To Collect)', 'रु ' . number_format($givenRemaining, 2))
                ->description($activeGivenCount . ' active ' . ($activeGivenCount === 1 ? 'receivable' : 'receivables'))
                ->descriptionIcon('heroicon-m-arrow-up-right')
                ->color('info'),

            Stat::make('Debts (To Repay)', 'रु ' . number_format($takenRemaining, 2))
                ->description($activeTakenCount . ' active ' . ($activeTakenCount === 1 ? 'payable' : 'payables'))
                ->descriptionIcon('heroicon-m-arrow-down-left')
                ->color('warning'),
        ];
    }
}
