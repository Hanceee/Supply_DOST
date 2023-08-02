<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TranscationOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Transaction', Transaction::count()),
            Card::make('Total Closed', Transaction::where('remarks','Closed')->count()),
            Card::make('Latest Transaction', function() {
                $latestTransaction = Transaction::latest('created_at')->first();
                return $latestTransaction ? $latestTransaction->supplier->supplier_name : '';
            }),

            Card::make('Highest Average Rating', function() {
                $highestRating = Transaction::max('rating');
                $transactionWithHighestRating = Transaction::where('rating', $highestRating)->latest('created_at')->first();
                return $transactionWithHighestRating ? $highestRating . ': ' . $transactionWithHighestRating->supplier->supplier_name : '';
            }),


        ];
    }
}
