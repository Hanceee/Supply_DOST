<?php

namespace App\Filament\Resources\ServerEmailResource\Pages;

use App\Filament\Resources\ServerEmailResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageServerEmails extends ManageRecords
{
    protected static string $resource = ServerEmailResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
