<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Filament\Widgets\LineChartWidget;

class Chart2 extends LineChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $heading = 'Expenses Over Time';
    protected static ?string $maxHeight = '350px';
    protected function getData(): array
    {
        $transactions = Transaction::orderBy('date')->get();

        $datasets = [
            [
                'label' => 'Expenses',
                'data' => $transactions->pluck('price'), // Assuming you want to plot the price of transactions over time
                'borderColor' => 'rgba(255, 99, 132, 1)', // Set the line color
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Set the fill color
            ],
        ];

        $labels = $transactions->pluck('date')->map(function ($date) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('M d, Y'); // Format the date labels as desired
        });
        return [
            'datasets' => $datasets,
            'labels' => $labels,        ];
    }
}
