<?php

namespace App\Filament\App\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class IncomeVsExpense extends ApexChartWidget
{
    protected static ?string $chartId = 'incomeVsExpense';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected static ?string $heading = 'Monthly Ratio (Income vs Expense)';

    protected function getOptions(): array
    {
        $user = auth()->user();
        $income = 0.0;
        $expense = 0.0;

        if ($user) {
            $income = (float) $user->incomeRecords()
                ->whereYear('date', now()->year)
                ->whereMonth('date', now()->month)
                ->sum('amount');

            $expense = (float) $user->expenseRecords()
                ->whereYear('date', now()->year)
                ->whereMonth('date', now()->month)
                ->sum('amount');
        }

        $hasData = ($income > 0 || $expense > 0);

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 320,
            ],
            'series' => $hasData ? [$income, $expense] : [],
            'labels' => ['Income', 'Expense'],
            'colors' => ['#10b981', '#ef4444'],
            'legend' => [
                'position' => 'bottom',
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
            'noData' => [
                'text' => 'No income or expense this month',
                'align' => 'center',
                'verticalAlign' => 'middle',
                'style' => [
                    'color' => '#94a3b8',
                    'fontSize' => '13px',
                    'fontFamily' => 'inherit',
                ],
            ],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '70%',
                        'labels' => [
                            'show' => $hasData,
                            'name' => [
                                'show' => true,
                                'fontSize' => '14px',
                                'fontFamily' => 'inherit',
                            ],
                            'value' => [
                                'show' => true,
                                'fontSize' => '16px',
                                'fontWeight' => 'bold',
                                'fontFamily' => 'inherit',
                                'formatter' => 'function(val) { return "रु " + Number(val).toLocaleString(); }',
                            ],
                            'total' => [
                                'show' => true,
                                'label' => 'Net',
                                'fontFamily' => 'inherit',
                                'formatter' => 'function(w) { return "रु " + (' . ($income - $expense) . ').toLocaleString(); }',
                            ],
                        ],
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => $hasData,
                'formatter' => 'function(val) { return val.toFixed(1) + "%"; }',
            ],
        ];
    }
}
