<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplierResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\SupplierResource\RelationManagers\TransactionRelationManager;
use Filament\Forms\Components\Fieldset;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $navigationGroup = 'Supplier Management';


    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Card::make()

    ->schema([
        Forms\Components\Select::make('category_id')
        ->relationship('category', 'name', fn (Builder $query) => $query->where('hidden', 0))
        ->label('Category Name')
        ->required()
        ->preload()
        ,
        Fieldset::make('Supplier Information')
    ->schema([

        Forms\Components\TextInput::make('supplier_name')
        ->label('Supplier Name')
        ->autofocus()
        ->required()
        ->placeholder('Supplier Name')
            ->maxLength(255),
        Forms\Components\TextInput::make('representative_name')
        ->label('Representative Name')
        ->required()
        ->hint('Full name, including middle initials.')
        ->placeholder('Representative Name')
            ->maxLength(255),
        Forms\Components\TextInput::make('position_designation')
        ->label('Position/Designation')
        ->required()
        ->hint('Ex. Manager, Assistant, Owner, etc.')
        ->placeholder('Position/Designation')
            ->maxLength(255),
        Forms\Components\TextInput::make('company_address')
        ->label('Company/Address')
        ->required()
        ->placeholder('Company/Address')
            ->maxLength(255),
        Forms\Components\TextInput::make('office_contact')
        ->label('Office Contact No./Fax/Mobile')
        ->required()
        ->placeholder('Office Contact No./Fax/Mobile')
            ->maxLength(255),
        Forms\Components\TextInput::make('email')
        ->label('Email Address/es')
        ->email()
        ->required()
        ->hint('Ex. example@email.com')
        ->placeholder('Email Address/es')
            ->maxLength(255),
        Forms\Components\TextInput::make('business_permit_number')
        ->label("Business/Mayors's Permit Number")
        ->required()
        ->placeholder("Business/Mayors's Permit Number")
            ->maxLength(255),
        Forms\Components\TextInput::make('tin')
        ->label('Tax Identification Number (TIN)')
        ->required()
        ->placeholder('Tax Identification Number (TIN)')
            ->maxLength(255),
        Forms\Components\TextInput::make('philgeps_registration_number')
        ->label('PhilGEPS Registration Number')
        ->required()
        ->placeholder('PhilGEPS Registration Number')
            ->maxLength(255),
            ])
            ->inlineLabel()
    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        // $table->headerActions([
        //     FilamentExportHeaderAction::make('export')


        // ]);
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('supplier_name')->searchable(),
                Tables\Columns\TextColumn::make('representative_name')->searchable(),
                Tables\Columns\TextColumn::make('position_designation')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('company_address')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('office_contact')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('email')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('business_permit_number')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('tin')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('philgeps_registration_number')->searchable()->hiddenFrom('md'),
                Tables\Columns\TextColumn::make('category.name')->searchable(),
                Tables\Columns\TextColumn::make('transaction_count')->counts('transaction')->sortable(),
                Tables\Columns\TextColumn::make('transaction_avg_rating')->searchable()->avg('transaction','rating')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true)->sortable(),
            ])
            ->filters([

                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('Export All'),
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ForceDeleteAction::make(),]),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),

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
            'view' => Pages\ViewSupplier::route('/{record}'),

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
