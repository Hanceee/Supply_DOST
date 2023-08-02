<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CategoryOverview extends BaseWidget
{
    protected function getCards(): array
    {

        return [
            Card::make('Total Category',Category::count()),
                    Card::make('Total Visible Category', Category::where('hidden','0')->count()),

            Card::make('Latest Category', Category::latest('created_at')->value('name')),

        ];
    }
}
