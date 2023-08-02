<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\BubbleChartWidget;
use Filament\Widgets\RadarChartWidget;

class Chart1 extends RadarChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $heading = 'Supplier Ratings Radar Chart';
    protected static ?string $maxHeight = '350px';
    protected function getData(): array
    {
        $suppliers = Supplier::all();

        $datasets = [];
        $colors = ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)']; // Add more colors as needed

        foreach ($suppliers as $key => $supplier) {
            $datasets[] = [
                'label' => $supplier->supplier_name,
                'data' => [
                    $supplier->transactions->avg('quality_rating'),
                    $supplier->transactions->avg('completeness_rating'),
                    $supplier->transactions->avg('conformity_rating'),
                    $supplier->transactions->avg('rating'), // Average Rating
                ],
                'backgroundColor' => $colors[$key % count($colors)], // Change the color here
                'borderColor' => $colors[$key % count($colors)], // Change the border color here
                'pointBackgroundColor' => $colors[$key % count($colors)], // Change the data point color here
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => ['Quality Rating', 'Completeness Rating', 'Conformity Rating', 'Average Rating'],
        ];
    }
}
