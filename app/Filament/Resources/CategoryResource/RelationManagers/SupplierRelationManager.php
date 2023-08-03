<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class SupplierRelationManager extends RelationManager
{
    protected static string $relationship = 'supplier';

    protected static ?string $recordTitleAttribute = 'supplier_name';



     public static function table(Table $table): Table
    {
        return $table
        ->columns([

            Split::make([


                Stack::make([
                    Tables\Columns\TextColumn::make('supplier_name')
                    ->searchable()
                    ->label('Supplier Name')
                    ->icon('heroicon-o-truck')
                    ->color('primary')->copyable()
                    ->size('lg')
                    ->weight('bold'),
                    Tables\Columns\BadgeColumn::make('category.name')
                    ->icons(['heroicon-o-folder'])
                    ->label('Category')->copyable()
                    ->colors(['secondary'])
                    ->searchable(),
                    Tables\Columns\TextColumn::make('company_address')
                ->label('Company/Address')
                ->searchable()->copyable()
                ->size('sm')
                ->icon('heroicon-s-globe')
                ->color('secondary'),
                ])->alignment('left')->space(1),
                Stack::make([
                    Tables\Columns\TextColumn::make('representative_name')
                ->searchable()->copyable()
                ->label('Representative')
                ->color('secondary')
                ->icon('heroicon-s-user'),

            Tables\Columns\TextColumn::make('position_designation')
                ->searchable()->copyable()
                ->label('Company/Address')
                ->size('sm')
                ->color('secondary')
                ->icon('heroicon-s-briefcase'),


            Tables\Columns\TextColumn::make('office_contact')
                ->searchable()->copyable()
                ->label('Office Contact No./Fax/Mobile')
                ->icon('heroicon-s-phone')
                ->color('secondary')
                ->size('sm'),

            Tables\Columns\TextColumn::make('email')
                ->searchable()->copyable()
                ->label('Email Address/es')
                ->icon('heroicon-s-at-symbol')
                ->color('secondary')
                ->size('sm'),
                ])->space(1)->alignment('center'),

                Stack::make([
                    Tables\Columns\TextColumn::make('transaction_count')
                    ->counts('transaction')
                    ->label('Transaction Count')->copyable()
                    ->sortable()
                    ->icon('heroicon-o-currency-dollar')
                    ->size('lg')
                    ->color('success'),

                Tables\Columns\TextColumn::make('transaction_avg_rating')

                    ->label('Overall Average')
                    ->avg('transaction', 'rating')->copyable()
                    ->sortable()
                    ->size('lg')
                    ->icon('heroicon-s-star')
                    ->color('warning'),
                ])->alignment('right')->space(3),


            ]),
            Panel::make([
                Stack::make([
                    Tables\Columns\TextColumn::make('business_permit_number')
                    ->label('Post title')
                    ->label('Permit')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => __("Permit: {$state}")),

                Tables\Columns\TextColumn::make('tin')
                    ->searchable()
                    ->label('TIN')
                    ->formatStateUsing(fn (string $state): string => __("TIN: {$state}")),

                Tables\Columns\TextColumn::make('philgeps_registration_number')
                    ->searchable()
                    ->label('PhilGEPS')
                    ->formatStateUsing(fn (string $state): string => __("PhilGEPS: {$state}")),
                    Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => __("Created at {$state}")),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => __("Updated at {$state}")),
                ])->space(2),
            ])->collapsible(),




        ])
        ->filters([
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
