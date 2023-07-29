<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Transaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\TransactionResource\RelationManagers\SupplierRelationManager;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationGroup = 'Supplier Management';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('article_description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'supplier_name')
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('quality_rating')
                    ->required(),
                Forms\Components\TextInput::make('completeness_rating')
                    ->required(),
                Forms\Components\TextInput::make('conformity_rating')
                    ->required(),
                Forms\Components\TextInput::make('remarks')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('date')
                //     ->date(),
                // Tables\Columns\TextColumn::make('article_description'),
                // Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('supplier.supplier_name'),
                Tables\Columns\TextColumn::make('quality_rating'),
                Tables\Columns\TextColumn::make('completeness_rating'),
                Tables\Columns\TextColumn::make('conformity_rating'),
                TextColumn::make('rating')

                // ->placeholder(function(Model $record): float  {
                //         return ($record->quality_rating + $record->completeness_rating + $record->conformity_rating) / 3 ;
                // })
                ,
                // Tables\Columns\TextColumn::make('remarks'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SupplierRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }


}
