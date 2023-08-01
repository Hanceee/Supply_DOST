<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Transaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\TextInput\Mask;
use Wiebenieuwenhuis\FilamentCharCounter\Textarea;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Wiebenieuwenhuis\FilamentCharCounter\TextInput;
use Yepsua\Filament\Tables\Components\RatingColumn;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Suleymanozev\FilamentRadioButtonField\Forms\Components\RadioButton;
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


                Grid::make(2)
    ->schema([
        Card::make()
    ->schema([
        Wizard::make([
            Wizard\Step::make('Order')
                ->icon('heroicon-o-shopping-bag')
                ->schema([
                    Forms\Components\DatePicker::make('date')
                    ->required()
                    ->label('Transaction Date')
                    ->placeholder('Transaction Date'),
                    Textarea::make('article_description')
                    ->placeholder('Article/Description')
                    ->required()
                    ->disableAutocomplete()
                    ->label('Article/Description')
                    ->characterLimit(200),
                Forms\Components\TextInput::make('price')
                    ->mask(fn (Mask $mask) => $mask->money(prefix: '₱', thousandsSeparator: ',', decimalPlaces: 2))
                    ->placeholder('Grand Total Cost')
                    ->disableAutocomplete()
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'supplier_name')
                    ->preload()
                    ->label('Supplier')
                    ->required(),
                ]),
            Wizard\Step::make('Billing')
                ->icon('heroicon-o-shopping-bag')
                ->schema([
                    Forms\Components\TextInput::make('quality_rating')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->disableAutocomplete()
                    ->maxValue(5)
                    ->label('Quality Rating')
                    ->placeholder('Quality Rating')
                    ,
                    Forms\Components\TextInput::make('completeness_rating')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->disableAutocomplete()
                    ->maxValue(5)
                    ->label('Completeness Rating')
                    ->placeholder('Completeness Rating')
                   ,
                   Forms\Components\TextInput::make('conformity_rating')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5)
                    ->disableAutocomplete()
                    ->label('Conformity Ratings')
                    ->placeholder('Conformity Ratings')
                    ,

                ]),
        ])
    ]),
    Card::make()
    ->schema([
        RadioButton::make('remarks')
                    ->label('Remarks')
                    ->required()
                    ->options([
                        'Processing' => 'Processing',
                        'Cancelled' => 'Cancelled',
                        'Closed' => 'Closed',


                    ])
                    ->descriptions([
                        'Closed' => 'Transaction is completed successfully.',
                        'Cancelled' => 'Transaction revoked.',
                        'Processing' => 'Transaction on process.',
                    ])
                    ->default('Processing'),
    ])
    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('article_description'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('supplier.supplier_name')->searchable(),
                RatingColumn::make('quality_rating')->color('orange'),
                RatingColumn::make('completeness_rating')->color('green'),
                RatingColumn::make('conformity_rating')->color('cyan'),
                TextColumn::make('rating') ,
                Tables\Columns\BadgeColumn::make('remarks')
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

                Tables\Actions\ForceDeleteAction::make(),    ]),
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
            SupplierRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
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
