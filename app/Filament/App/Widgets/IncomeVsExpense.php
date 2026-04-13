<?php

namespace App\Filament\App\Widgets;

use App\Models\ExpenseRecord;
use App\Models\IncomeRecord;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class IncomeVsExpense extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'incomeVsExpense';
    protected static ?int $sort = 2;

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Income vs. Expense this month';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $income = IncomeRecord::whereMonth('date', now()->month)->where('user_id', auth()->id())->get()->sum('amount');
        $expense = ExpenseRecord::whereMonth('date', now()->month)->where('user_id', auth()->id())->get()->sum('amount');
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$income, $expense],
            'labels' => ['Income', 'Expense'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'colors' => ['#10B981', '#EF4444'], // Emerald and Red colors
        ];
    }
}
