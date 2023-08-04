<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Supplier;

class Chart4 extends BarChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '350px';
    protected static ?string $heading = 'Top 5 Suppliers';

    protected function getData(): array
    {
        $suppliers = Supplier::with('transactions')
            ->whereHas('transactions', function ($query) {
                $query->where('remarks', '!=', 'Cancelled');
            })
            ->get();

        $averageRatings = [];

        foreach ($suppliers as $supplier) {
            $averageRating = $supplier->transactions->avg('rating');
            $averageRatings[$supplier->supplier_name] = $averageRating;
        }

        arsort($averageRatings);

        // Get the top 5 suppliers and their average ratings
        $topSuppliers = array_slice($averageRatings, 0, 5, true);

        // Define an array of different colors for each bar
        $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#FF9F40'];

        $datasets = [
            [
                'label' => 'Average Rating',
                'data' => array_values($topSuppliers),
                'backgroundColor' => array_slice($colors, 0, count($topSuppliers)),
            ],
        ];

        $labels = array_keys($topSuppliers);

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
