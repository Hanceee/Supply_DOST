<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class SupplierRelationManager extends RelationManager
{
    protected static string $relationship = 'supplier';

    protected static ?string $recordTitleAttribute = 'supplier_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('Export All'),
            ])
            ->actions([

            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
            ]);
    }
}
