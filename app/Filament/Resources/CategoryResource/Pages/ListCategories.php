<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Widgets\categorychart;
use App\Filament\Resources\CategoryResource\Widgets\categorychart2;
use App\Filament\Resources\CategoryResource\Widgets\CategoryOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CategoryOverview::class,
            categorychart::class,
            categorychart2::class


        ];
    }

}
