<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Transaction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransaction extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected function getTableQuery(): Builder
    {
        return Transaction::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('date')
            ->sortable()->date()
            ->icon('heroicon-s-calendar')
            ->copyable()->searchable(),
                Tables\Columns\TextColumn::make('supplier.supplier_name')->copyable()->searchable()->label('Supplier')->icon('heroicon-o-truck'),

            Tables\Columns\TextColumn::make('article_description')->copyable()->searchable()->label('Article/Description')->toggleable(isToggledHiddenByDefault: true)->wrap(),
            Tables\Columns\TextColumn::make('price')->copyable()->searchable()->label('Amount')->money('php')->sortable(),
            Tables\Columns\TextColumn::make('quality_rating')->copyable()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('completeness_rating')->copyable()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('conformity_rating')->copyable()->searchable()->sortable(),
            TextColumn::make('rating')->copyable()->label('Average Rating')->searchable()
            ->icon('heroicon-s-star')
            ->color('warning')->sortable(),
            Tables\Columns\BadgeColumn::make('remarks')->searchable()
            ->colors([
                'primary',
                'secondary' => 'Processing',
                'success' => 'Closed',
                'danger' => 'Cancelled',
            ])

            ->icons([
                'heroicon-o-check' => 'Closed',
                    'heroicon-o-x-circle' => 'Cancelled',
                    'heroicon-o-document' => 'Processing',
            ])
            ,
            Tables\Columns\TextColumn::make('user.name')->searchable()->copyable()->icon('heroicon-o-users')->label('End User')->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
            ->searchable()->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
            ->searchable()->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
        ];
    }

}
