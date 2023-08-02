<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BubbleChartWidget;
use App\Models\Supplier;

class Chart4 extends BubbleChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '350px';
    protected static ?string $heading = 'Supplier Distribution by Category';

    protected function getData(): array
    {
        $suppliers = Supplier::with('category')->get();

        $datasets = [];

        $colors = ['#FF5733', '#36A2EB', '#FFCE56', '#FF6384', '#36A2EB', '#FFCE56']; // Add more colors as needed

        foreach ($suppliers as $key => $supplier) {
            $datasets[] = [
                'label' => $supplier->supplier_name,
                'data' => [
                    [
                        'x' => $supplier->category->name, // Assuming you have a 'category_name' column in the 'categories' table
                        'y' => $supplier->id, // Using supplier ID as the y-axis value
                        'r' => 10, // You can set the bubble size based on any criteria you want
                    ],
                ],
                'backgroundColor' => $colors[$key % count($colors)],
            ];
        }

        return [
            'datasets' => $datasets,
        ];
    }
}
