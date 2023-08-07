<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Filament\Widgets\LineChartWidget;


class TransactionChart1 extends LineChartWidget
{
    protected static ?string $heading = 'Transaction Trends';
    protected static ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $transactions = Transaction::where('remarks', '!=', 'Cancelled')
            ->orderBy('date')
            ->get();

        $datasets = [
            [
                'label' => 'Processing/Closed Transaction',
                'data' => $transactions->pluck('price'), // Assuming you want to plot the price of transactions over time
                'borderColor' => 'rgba(255, 99, 132, 1)', // Set the line color
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Set the fill color
            ],
        ];

        $labels = $transactions->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d, Y'); // Format the date labels as desired
        });

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
