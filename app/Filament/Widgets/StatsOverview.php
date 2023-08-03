<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Transaction;
use App\Models\Supplier;

class StatsOverview extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected function getCards(): array
    {
        // Calculate the data for each card
        $chartData = collect(range(1, 7))->map(function () {
            return random_int(1, 20);
        });
        $totalExpenses = Transaction::sum('price');
        $totalTransactions = Transaction::count();
        $averageTransactionAmount = ($totalTransactions > 0) ? $totalExpenses / $totalTransactions : 0;
        $mostExpensiveSupplier = Supplier::withMax('transactions', 'price')->first();
        $highRatedSuppliersCount = Transaction::where('rating', '>=', 4.0)->count();


        return [
            Card::make('Total Expenses', '₱' . number_format($totalExpenses, 2))
            ->description('Total expenses incurred')
            ->descriptionIcon('heroicon-o-currency-dollar')
            ->chart($chartData->toArray())
            ->color('primary'),
            Card::make('Average Transaction Amount', '₱' . number_format($averageTransactionAmount, 2))
            ->description('Average transaction amount')
                ->descriptionIcon('heroicon-o-chart-pie')
                ->chart($chartData->toArray())
                ->color('success'),
                Card::make('Most Expensive Supplier', $mostExpensiveSupplier->supplier_name ?? 'N/A')
                ->description('Supplier with the highest expenses')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart($chartData->toArray())
                ->color('danger'),
                Card::make('Total Suppliers with High Ratings', $highRatedSuppliersCount)
                ->description('Supplier with the highest ratings (4.0 or above)')
                ->descriptionIcon('heroicon-s-star')
                ->chart($chartData->toArray())
                ->color('warning'),

            Card::make('Total Transactions this Year', Transaction::whereYear('date', now()->year)->count())
            ->description('Total transactions this year')
            ->descriptionIcon('heroicon-s-calendar')
            ->chart($chartData->toArray())
            ->color('secondary'),
            Card::make('Total Transactions this Month', Transaction::whereMonth('date', now()->month)->count())
            ->description('Total transactions this month')
                ->descriptionIcon('heroicon-s-calendar')
                ->chart($chartData->toArray())
                ->color('secondary'),
        ];
    }
}
