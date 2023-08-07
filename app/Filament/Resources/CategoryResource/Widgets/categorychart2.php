<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use App\Models\Supplier;
use Filament\Widgets\BarChartWidget;

class categorychart2 extends BarChartWidget
{
    protected static ?string $heading = 'Transaction Count by Category';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $categories = Category::with(['suppliers.transactions' => function ($query) {
            $query->where('remarks', '!=', 'Cancelled');
        }])->get();

        // Define an array of colors associated with each category
        $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#FF9F40']; // Add more colors if needed

        $datasets = [
            [
                'label' => 'Processing/Closed Transactions',
                'data' => $categories->map(function ($category) {
                    return $category->suppliers->sum(function ($supplier) {
                        return $supplier->transactions->count();
                    });
                }),
                'backgroundColor' => $colors,
            ],
        ];

        $labels = $categories->pluck('name');

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
