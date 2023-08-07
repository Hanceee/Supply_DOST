<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TranscationOverview extends BaseWidget
{

    protected function getCards(): array
    {
        $chartData = collect(range(1, 7))->map(function () {
            return random_int(1, 20);
        });
        // where('remarks', '!=', 'Cancelled')
        return [
            Card::make('Total Transaction', Transaction::where('remarks', '!=', 'Cancelled')->count())->chart($chartData->toArray())->color('success'),
Card::make('Total Closed', Transaction::where('remarks', 'Closed')->count())->chart($chartData->toArray())->color('success'),
Card::make('Latest Transaction', function () {
    $latestTransaction = Transaction::where('remarks', '!=', 'Cancelled')->latest('created_at')->first();
    return $latestTransaction ? $latestTransaction->supplier->supplier_name : '';
})->chart($chartData->toArray())->color('success'),

Card::make('Highest Average Rating', function () {
    $highestRating = Transaction::where('remarks', '!=', 'Cancelled')->max('rating');
    $transactionWithHighestRating = Transaction::where('rating', $highestRating)->latest('created_at')->first();
    return $transactionWithHighestRating ? $highestRating . ': ' . $transactionWithHighestRating->supplier->supplier_name : '';
})->chart($chartData->toArray())->color('success'),



        ];
    }
}
