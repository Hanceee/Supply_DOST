<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Supplier;
use App\Models\Transaction;


class Chart3 extends PieChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '380px';
    protected static ?string $heading = 'Transaction Distribution by Supplier';
    protected function getData(): array
    {
        $suppliers = Supplier::whereHas('transactions', function ($query) {
            $query->where('remarks', '!=', 'Cancelled');
        })
        ->withCount(['transactions' => function ($query) {
            $query->where('remarks', '!=', 'Cancelled');
        }])
        ->get();

        $datasets = [
            [
                'label' => 'Suppliers',
                'data' => $suppliers->pluck('transactions_count'),
                'backgroundColor' => [
                    '#FF5733', // Red
                    '#36A2EB', // Blue
                    '#FFCE56', // Yellow
                    // Add more colors for other suppliers if needed
                ],
            ],
        ];

        $labels = $suppliers->pluck('supplier_name');
        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
