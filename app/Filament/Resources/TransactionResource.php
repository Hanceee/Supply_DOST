<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Transaction;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Doctrine\DBAL\Schema\Schema;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
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
use App\Filament\Resources\CategoryResource\Widgets\TransactionOverview;
use App\Filament\Resources\TransactionResource\Widgets\TranscationOverview;
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
            Grid::make(3)
    ->schema([



        Card::make()
            ->schema([

                Wizard::make([
                    Wizard\Step::make('Details')
                        ->icon('bi-currency-dollar')
                        ->description('Please enter transaction details.')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'supplier_name')
                            ->preload()
                            ->helperText('Please select the supplier name from the list below.')
                            ->label('Supplier')
                            ->columnSpan('full')
                            ->required(),


                            Forms\Components\DatePicker::make('date')
                            ->required()
                            ->label('Transaction Date')
                            ->placeholder('Transaction Date')
                            ,




                        Forms\Components\TextInput::make('price')
                            ->mask(fn (Mask $mask) => $mask->money(prefix: '₱', thousandsSeparator: ',', decimalPlaces: 2))
                            ->placeholder('Grand Total Cost')
                            ->disableAutocomplete()
                            ->numeric()
                            ->required(),



                            Textarea::make('article_description')
                            ->placeholder('Article/Description')
                            ->required()
                            ->disableAutocomplete()
                            ->label('Article/Description')
                            ->characterLimit(200)
                            ->columnSpan('full'),
                        ]),
                    Wizard\Step::make('Rating')
                        ->columns(3)
                        ->icon('bi-star')
                        ->description('Please rate transaction 0.1-5.')
                        ->schema([
                            Forms\Components\TextInput::make('quality_rating')
                            ->required()
                            ->numeric()
                            ->columnSpan(2)
                            ->minValue(0)
                            ->disableAutocomplete()
                            ->maxValue(5)
                            ->label('Quality ')
                            ->placeholder('Quality Rating'),

                        Forms\Components\TextInput::make('completeness_rating')
                            ->required()
                            ->numeric()
                            ->columnSpan(2)
                            ->minValue(0)
                            ->disableAutocomplete()
                            ->maxValue(5)
                            ->label('Completeness Rating')
                            ->placeholder('Completeness Rating'),

                        Forms\Components\TextInput::make('conformity_rating')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->columnSpan(2)
                            ->maxValue(5)
                            ->disableAutocomplete()
                            ->label('Conformity Rating')
                            ->placeholder('Conformity Rating'),
                        ]),

                    ])->skippable(),

        ])->columnSpan(2),


        Card::make()
        ->schema([
            Section::make('End User')

            ->schema([
            Forms\Components\Select::make('user_id')
            ->relationship('user', 'name')
            ->preload()
            ->columnSpan('full')
            ->label('Names')
            ->helperText('Please select your name from the list below.')
            ->required(),
            ]),
             Radio::make('remarks')
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





    ])->columnSpan(1),




    ])

        ]);

    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                ->sortable()->date()->icon('bi-calendar3')->copyable()->searchable(),
                    Tables\Columns\TextColumn::make('supplier.supplier_name')->copyable()->searchable()->label('Supplier')->icon('heroicon-o-truck'),

                Tables\Columns\TextColumn::make('article_description')->copyable()->searchable()->label('Article/Description')->toggleable(isToggledHiddenByDefault: true)->wrap(),
                Tables\Columns\TextColumn::make('price')->sortable()->copyable()->searchable()->label('Amount')->money('php')->sortable(),
                Tables\Columns\TextColumn::make('quality_rating')->copyable()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('completeness_rating')->copyable()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('conformity_rating')->copyable()->searchable()->sortable(),
                TextColumn::make('rating')->copyable()->label('Average Rating')->searchable()->icon('bi-star-fill')->color('warning')->sortable(),
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
                Tables\Columns\TextColumn::make('user.name')->searchable()->copyable()->icon('heroicon-o-users')->label('End User')->toggleable(isToggledHiddenByDefault: true),
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
    public static function getWidgets(): array
    {
        return [
            TranscationOverview::class
        ];
    }

}
