<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Pages\Actions;
use App\Filament\Resources\CategoryResource\Widgets\TransactionOverview;
use App\Filament\Resources\TransactionResource\Widgets\TranscationOverview;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            TranscationOverview::class
        ];
    }
    protected function getTableFiltersFormColumns(): int
{
    return 3;
}
}
