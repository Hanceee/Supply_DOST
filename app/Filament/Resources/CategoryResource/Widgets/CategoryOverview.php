<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CategoryOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getCards(): array
    {
        $chartData = collect(range(1, 7))->map(function () {
            return random_int(1, 20);
        });
        return [
            Card::make('Total Category',Category::count())->color('danger')->chart($chartData->toArray()),
            Card::make('Total Visible Category', Category::where('hidden','0')->count())->color('danger')->chart($chartData->toArray()),
            Card::make('Latest Category', Category::latest('created_at')->value('name'))->color('danger')->chart($chartData->toArray()),

        ];
    }
}
