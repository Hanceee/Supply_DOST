<?php

namespace App\Filament\Resources\SupplierResource\Widgets;

use App\Models\Supplier;
use Filament\Widgets\BarChartWidget;

class SupplierChart2 extends BarChartWidget
{
    protected static ?string $heading = 'Top Suppliers by Average Rating';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $suppliers = Supplier::with(['transactions' => function ($query) {
            $query->where('remarks', '!=', 'Cancelled');
        }])->get();

        $supplierRatings = [];

        foreach ($suppliers as $supplier) {
            $averageRating = $supplier->transactions->avg('rating');
            $supplierRatings[$supplier->supplier_name] = $averageRating;
        }

        // Sort suppliers by average rating in descending order
        arsort($supplierRatings);

        // Get the top 5 suppliers with the highest average rating
        $topSuppliers = array_slice($supplierRatings, 0, 5, true);

        $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#FF9F40']; // Add more colors if needed

        $datasets = [
            [
                'label' => 'Average Rating - Processing/Closed',
                'data' => array_values($topSuppliers),
                'backgroundColor' => $colors, // Use the colors array here
            ],
        ];

        $labels = array_keys($topSuppliers);

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
