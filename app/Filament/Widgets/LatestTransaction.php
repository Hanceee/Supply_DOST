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
            ->date()
            ->icon('heroicon-s-calendar')
            ->copyable(),
                Tables\Columns\TextColumn::make('supplier.supplier_name')->copyable()->label('Supplier')->icon('heroicon-o-truck'),

            Tables\Columns\TextColumn::make('article_description')->copyable()->label('Article/Description')->toggleable(isToggledHiddenByDefault: true)->wrap(),
            Tables\Columns\TextColumn::make('price')
            ->formatStateUsing(function (string $state): string {
                // Convert the state (which should be a number) to a money format
                $moneyFormat = number_format((float) $state, 2, '.', ',');

                // Add the currency sign to the formatted number
                return '₱' . $moneyFormat;
            })

            ->copyable()->label('Amount')->color('success'),
            Tables\Columns\TextColumn::make('quality_rating')->copyable(),
            Tables\Columns\TextColumn::make('completeness_rating')->copyable(),
            Tables\Columns\TextColumn::make('conformity_rating')->copyable(),
            TextColumn::make('rating')->copyable()->label('Average Rating')
            ->icon('heroicon-s-star')
            ->color('warning'),
            Tables\Columns\BadgeColumn::make('remarks')
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
            Tables\Columns\TextColumn::make('user.name')->copyable()->icon('heroicon-o-users')->label('End User')->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
            ->dateTime()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
           ->dateTime()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

}
