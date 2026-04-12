<?php

namespace App\Filament\App\Widgets;

use App\Models\ExpenseRecord;
use App\Models\IncomeRecord;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalIncome = IncomeRecord::get()->sum('amount');
        $totalExpenses = ExpenseRecord::get()->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;
        $previousMonthIncome = IncomeRecord::whereMonth('date', now()->subMonth()->month)->get()->sum('amount');
        $previousMonthExpenses = ExpenseRecord::whereMonth('date', now()->subMonth()->month)->get()->sum('amount');
        $thisMonthIncome = IncomeRecord::whereMonth('date', now()->month)->get()->sum('amount');
        $thisMonthExpenses = ExpenseRecord::whereMonth('date', now()->month)->get()->sum('amount');
        $thisMonthNetProfit = $thisMonthIncome - $thisMonthExpenses;
        $incomeChange = $previousMonthIncome > 0 ? (($thisMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100 : 0;
        $expensesChange = $previousMonthExpenses > 0 ? (($thisMonthExpenses - $previousMonthExpenses) / $previousMonthExpenses) * 100 : 0;
        $netProfitChange = $previousMonthIncome > 0 && $previousMonthExpenses > 0 ? ((($thisMonthIncome - $thisMonthExpenses) - ($previousMonthIncome - $previousMonthExpenses)) / ($previousMonthIncome - $previousMonthExpenses)) * 100 : 0;
        return [
            Stat::make('total_income', $thisMonthIncome)
                ->label('Total Income this month')
                ->value('रु ' . number_format($thisMonthIncome, 2))
                ->description($incomeChange > 0 ? '+' . number_format($incomeChange, 2) . '%' : number_format($incomeChange, 2) . '%'),
            Stat::make('total_expenses', $thisMonthExpenses)
                ->label('Total Expenses this month')
                ->value('रु ' . number_format($thisMonthExpenses, 2))
                ->description($expensesChange > 0 ? '+' . number_format($expensesChange, 2) . '%' : number_format($expensesChange, 2) . '%'),
            Stat::make('net_profit', $thisMonthNetProfit)
                ->label('Net Profit this month')
                ->value('रु ' . number_format($thisMonthNetProfit, 2))
                ->description($netProfitChange > 0 ? '+' . number_format($netProfitChange, 2) . '%' : number_format($netProfitChange, 2) . '%'),
        ];
    }
}
