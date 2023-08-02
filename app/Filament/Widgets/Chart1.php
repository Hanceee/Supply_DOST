<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use Filament\Widgets\BarChartWidget;

class Chart1 extends BarChartWidget
{    protected static ?int $sort = 2;

    protected static ?string $heading = 'Total Counts';
    protected static ?string $maxHeight = '350px';
    protected function getData(): array
    {

        $totalSuppliers = Supplier::count();
        $totalCategories = Category::count();
        $totalTransactions = Transaction::count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Suppliers',
                    'data' => [$totalSuppliers],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Change the color here
                ],
                [
                    'label' => 'Total Categories',
                    'data' => [$totalCategories],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', // Change the color here

                ],
                [
                    'label' => 'Total Transactions',
                    'data' => [$totalTransactions],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Change the color here

                ],
            ],
            'labels' => ['Count'],
        ];
    }
}
