<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplierResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
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

        \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('supplier_name')
        ->label('Supplier Name')
        ->autofocus()
        ->required()
        ->placeholder('Supplier Name')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('representative_name')
        ->label('Representative Name')
        ->required()
        ->hint('Full name, including middle initials.')
        ->placeholder('Representative Name')
        ->maxLength(100),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('position_designation')
        ->label('Position/Designation')
        ->required()
        ->hint('Ex. Manager, Assistant, Owner, etc.')
        ->placeholder('Position/Designation')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('company_address')
        ->label('Company/Address')
        ->required()
        ->placeholder('Company/Address')
        ->maxLength(100),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('office_contact')
        ->label('Office Contact No./Fax/Mobile')
        ->required()
        ->placeholder('Office Contact No./Fax/Mobile')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('email')
        ->label('Email Address/es')
        ->email()
        ->required()
        ->hint('Ex. example@email.com')
        ->placeholder('Email Address/es')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('business_permit_number')
        ->label("Business/Mayors's Permit Number")
        ->required()
        ->placeholder("Business/Mayors's Permit Number")
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('tin')
        ->label('Tax Identification Number (TIN)')
        ->required()
        ->placeholder('Tax Identification Number (TIN)')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('philgeps_registration_number')
        ->label('PhilGEPS Registration Number')
        ->required()
        ->placeholder('PhilGEPS Registration Number')
        ->maxLength(50),
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
        ->contentGrid([
            'md' => 1,
            'xl' => 2,
        ])
        ->columns([

            Split::make([


                Stack::make([
                    Tables\Columns\TextColumn::make('supplier_name')
                    ->searchable()
                    ->label('Supplier Name')
                    ->icon('heroicon-o-truck')
                    ->color('primary')
                    ->size('lg')
                    ->weight('bold'),
                    Tables\Columns\BadgeColumn::make('category.name')
                    ->icons(['heroicon-o-folder'])
                    ->label('Category')
                    ->colors(['secondary'])
                    ->searchable(),
                    Tables\Columns\TextColumn::make('company_address')
                ->label('Company/Address')
                ->searchable()
                ->size('sm')
                ->icon('bi-pin-map-fill')
                ->color('secondary'),
                ])->alignment('left')->space(1),
                Stack::make([
                    Tables\Columns\TextColumn::make('representative_name')
                ->searchable()
                ->label('Representative')
                ->color('secondary')
                ->icon('heroicon-s-user'),

            Tables\Columns\TextColumn::make('position_designation')
                ->searchable()
                ->label('Company/Address')
                ->size('sm')
                ->color('secondary')
                ->icon('heroicon-s-briefcase'),


            Tables\Columns\TextColumn::make('office_contact')
                ->searchable()
                ->label('Office Contact No./Fax/Mobile')
                ->icon('bi-telephone-fill')
                ->color('secondary')
                ->size('sm'),

            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->label('Email Address/es')
                ->icon('bi-envelope-fill')
                ->color('secondary')
                ->size('sm'),
                ])->space(1)->alignment('center'),

                Stack::make([
                    Tables\Columns\TextColumn::make('transaction_count')
                    ->counts('transaction')
                    ->label('Transaction Count')
                    ->sortable()
                    ->icon('bi-cash-stack')
                    ->size('lg')
                    ->color('success'),

                Tables\Columns\TextColumn::make('transaction_avg_rating')

                    ->label('Rating')
                    ->avg('transaction', 'rating')
                    ->sortable()
                    ->size('lg')
                    ->icon('bi-star-fill')
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
                Filter::make('created_at')
    ->form([
        Forms\Components\DatePicker::make('created_from'),
        Forms\Components\DatePicker::make('created_until')->default(now()),
    ]),
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('Category')
                ->relationship('category', 'name')
                ,
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
