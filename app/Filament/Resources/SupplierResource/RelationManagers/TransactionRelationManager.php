<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class TransactionRelationManager extends RelationManager
{
    protected static string $relationship = 'transaction';

    protected static ?string $recordTitleAttribute = 'rating';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

                ->columns([
                    Tables\Columns\TextColumn::make('date')
                    ->sortable()->date()->icon('bi-calendar3')->searchable(),
                        Tables\Columns\TextColumn::make('supplier.supplier_name')->searchable()->label('Supplier')->icon('heroicon-o-truck'),

                    Tables\Columns\TextColumn::make('article_description')->searchable()->label('Article/Description')->toggleable(isToggledHiddenByDefault: true)->wrap(),
                    Tables\Columns\TextColumn::make('price')->searchable()->label('Amount')->money('php')->sortable(),
                    Tables\Columns\TextColumn::make('quality_rating')->searchable()->sortable(),
                    Tables\Columns\TextColumn::make('completeness_rating')->searchable()->sortable(),
                    Tables\Columns\TextColumn::make('conformity_rating')->searchable()->sortable(),
                    TextColumn::make('rating')->label('Average Rating')->searchable()->icon('bi-star-fill')->color('warning')->sortable(),
                    Tables\Columns\BadgeColumn::make('remarks')->searchable()
                    ->colors([
                        'primary',
                        'secondary' => 'Processing',
                        'success' => 'Closed',
                        'danger' => 'Cancelled',
                    ])

                    ->icons([
                        'clarity-success-standard-solid' => 'Closed',
                        'clarity-times-circle-solid' => 'Cancelled',
                        'clarity-contract-solid' => 'Processing',
                    ])
                    ,
                    Tables\Columns\TextColumn::make('user.name')->searchable()->icon('heroicon-o-users')->label('End User')->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('created_at')
                    ->searchable()->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                    Tables\Columns\TextColumn::make('updated_at')
                    ->searchable()->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                ])

            ->filters([
                Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from'),
                    Forms\Components\DatePicker::make('created_until')->default(now()),
                ]),
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('remarks')
                ->options([
                    'Processing' => 'Processing',
                    'Cancelled' => 'Cancelled',
                    'Closed' => 'Closed',
                ]),
                SelectFilter::make('Supplier')->relationship('supplier', 'supplier_name'),
                SelectFilter::make('End User')->relationship('user', 'name'),

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
