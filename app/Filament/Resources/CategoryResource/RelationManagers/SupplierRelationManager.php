<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class SupplierRelationManager extends RelationManager
{
    protected static string $relationship = 'supplier';

    protected static ?string $recordTitleAttribute = 'supplier_name';



     public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_name'),
                Tables\Columns\TextColumn::make('representative_name'),
                Tables\Columns\TextColumn::make('position_designation'),
                Tables\Columns\TextColumn::make('company_address'),
                Tables\Columns\TextColumn::make('office_contact'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('business_permit_number')->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('tin')->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('philgeps_registration_number')->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('transaction_count')->counts('transaction')->sortable(),
                Tables\Columns\TextColumn::make('transaction_avg_rating')->avg('transaction','rating')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),

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
