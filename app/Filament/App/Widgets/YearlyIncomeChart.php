<?php

namespace App\Filament\App\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class YearlyIncomeChart extends ApexChartWidget
{
    protected static ?string $chartId = 'yearlyIncomeChart';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 2,
    ];

    protected static ?string $heading = 'Annual Cashflow (Income vs Expense)';

    protected function getOptions(): array
    {
        $user = auth()->user();
        $year = now()->year;

        $incomeData = [];
        $expenseData = [];

        if ($user) {
            $monthlyIncomes = $user->incomeRecords()
                ->selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $monthlyExpenses = $user->expenseRecords()
                ->selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            for ($m = 1; $m <= 12; $m++) {
                $incomeData[] = (float) ($monthlyIncomes[$m] ?? 0);
                $expenseData[] = (float) ($monthlyExpenses[$m] ?? 0);
            }
        } else {
            $incomeData = array_fill(0, 12, 0);
            $expenseData = array_fill(0, 12, 0);
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 320,
                'toolbar' => ['show' => false],
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '48%',
                    'borderRadius' => 4,
                ],
            ],
            'series' => [
                [
                    'name' => 'Income',
                    'data' => $incomeData,
                ],
                [
                    'name' => 'Expenses',
                    'data' => $expenseData,
                ],
            ],
            'colors' => ['#10b981', '#ef4444'],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'legend' => [
                'position' => 'top',
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'borderColor' => 'rgba(156, 163, 175, 0.15)',
            ],
        ];
    }
}
