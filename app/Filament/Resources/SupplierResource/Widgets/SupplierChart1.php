<?php

namespace App\Filament\Resources\SupplierResource\Widgets;

use App\Models\Supplier;
use Filament\Widgets\BarChartWidget;

class SupplierChart1 extends BarChartWidget
{
    protected static ?string $heading = 'Transaction Count by Supplier';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $suppliers = Supplier::withCount(['transactions' => function ($query) {
            $query->where('remarks', '!=', 'Cancelled');
        }])->get();

        $datasets = [
            [
                'label' => 'Processing/Closed Transaction',
                'data' => $suppliers->pluck('transactions_count'),
                'backgroundColor' => $this->generateColors(count($suppliers)),
            ],
        ];

        $labels = $suppliers->pluck('supplier_name');

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    // Generate unique colors for each supplier
    protected function generateColors($count)
    {
        $colors = [];

        // You can use any color generation logic here
        // For example, using random colors or predefined colors
        // For this example, we will use a set of predefined colors
        $predefinedColors = ['#FF5733', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#9966FF', '#00FFFF', '#FFD700'];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = $predefinedColors[$i % count($predefinedColors)];
        }

        return $colors;
    }
}
