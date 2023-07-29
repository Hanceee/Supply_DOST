<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplierResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Filament\Resources\SupplierResource\RelationManagers\TransactionRelationManager;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $navigationGroup = 'Supplier Management';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('representative_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('position_designation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('office_contact')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('business_permit_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('philgeps_registration_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name', fn (Builder $query) => $query->where('hidden', 0))
                    ->required()
                    ->preload()
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('supplier_name'),
                // Tables\Columns\TextColumn::make('representative_name'),
                // Tables\Columns\TextColumn::make('position_designation'),
                // Tables\Columns\TextColumn::make('company_address'),
                // Tables\Columns\TextColumn::make('office_contact'),
                // Tables\Columns\TextColumn::make('email'),
                // Tables\Columns\TextColumn::make('business_permit_number'),
                // Tables\Columns\TextColumn::make('tin'),
                // Tables\Columns\TextColumn::make('philgeps_registration_number'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('average_overall_rating')->avg('transactions','transaction_average_rating'),
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
            TransactionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
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
