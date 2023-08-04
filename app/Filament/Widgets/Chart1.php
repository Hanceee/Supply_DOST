<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\BubbleChartWidget;
use Filament\Widgets\RadarChartWidget;

class Chart1 extends BubbleChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $heading = 'Supplier Performance Overview';

    protected static ?string $maxHeight = '350px';
    protected function getData(): array
    {
        $suppliers = Supplier::with('transactions')
            ->whereHas('transactions', function ($query) {
                $query->where('remarks', '!=', 'Cancelled');
            })
            ->get();

        $datasets = [];

        // Define fixed colors for each supplier
        $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#FF9F40'];

        $colorIndex = 0; // Index to track the color for each supplier

        foreach ($suppliers as $supplier) {
            $transactionCount = $supplier->transactions->count();
            $averageRating = $supplier->transactions->avg('rating');
            $averagePrice = $supplier->transactions->avg('price');

            $datasets[] = [
                'label' => $supplier->supplier_name,
                'data' => [
                    [
                        'x' => $averagePrice,
                        'y' => $averageRating,
                        'r' => $transactionCount, // Use transaction count for bubble size
                    ],
                ],
                'backgroundColor' => $colors[$colorIndex],
                'borderColor' => 'rgba(255, 255, 255, 0.8)', // Set border color for better visibility
                'borderWidth' => 2, // Set border width for better visibility
                'hoverBorderColor' => 'rgba(255, 255, 255, 1)', // Set hover border color
                'hoverBorderWidth' => 2, // Set hover border width
            ];

            $colorIndex = ($colorIndex + 1) % count($colors); // Move to the next color or start over if all colors are used
        }

        return [
            'datasets' => $datasets,
        ];
    }
}
