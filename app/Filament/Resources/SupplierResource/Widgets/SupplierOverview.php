<?php

namespace App\Filament\Resources\SupplierResource\Widgets;

use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SupplierOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $chartData = collect(range(1, 7))->map(function () {
            return random_int(1, 20);
        });
        return [
        Card::make('Total Suppliers', Supplier::count())->color('primary')->chart($chartData->toArray()),
        Card::make('Latest Supplier', Supplier::latest('created_at')->value('supplier_name'))->color('primary')->chart($chartData->toArray()),
        ];
    }
}
