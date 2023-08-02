<?php

namespace App\Filament\Resources\SupplierResource\Widgets;

use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SupplierOverview extends BaseWidget
{
    protected function getCards(): array
    {

        return [
        Card::make('Total Suppliers', Supplier::count()),
        Card::make('Latest Supplier', Supplier::latest('created_at')->value('supplier_name')),
        ];
    }
}
