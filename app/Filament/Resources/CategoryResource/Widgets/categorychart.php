<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\BarChartWidget;

class categorychart extends BarChartWidget
{
    protected static ?string $heading = 'Supplier Count Overview';
    protected static ?string $maxHeight = '300px';
    protected function getData(): array
    {
        $categories = Category::withCount('suppliers')->get();

        // Define an array of colors associated with each category
        $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#FF9F40']; // Add more colors if needed

        $datasets = [
            [
                'label' => 'Suppliers Count',
                'data' => $categories->pluck('suppliers_count'),
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
