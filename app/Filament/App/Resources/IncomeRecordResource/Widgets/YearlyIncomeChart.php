<?php

namespace App\Filament\App\Resources\IncomeRecordResource\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class YearlyIncomeChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'yearlyIncomeChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'YearlyIncomeChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $monthlyIncomes = auth()->user()->incomeRecords()
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $data = [];
            foreach ($months as $month) {
                $data[] = $monthlyIncomes[$month] ?? 0;
            }
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => [7, 10, 13, 15, 18],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
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
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
