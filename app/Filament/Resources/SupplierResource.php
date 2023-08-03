<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
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
use App\Filament\Resources\SupplierResource\Widgets\SupplierOverview;
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
                Grid::make(3)
    ->schema([
        Wizard::make([
            Wizard\Step::make('Supplier Details')
            ->icon('heroicon-o-paper-clip')
            ->description('Please input supplier details')
                ->schema([
                    Grid::make()
                    ->schema([
                        Grid::make(2)
                        ->schema([
                        \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('supplier_name')
                        ->label('Supplier Name')
                        ->disableAutocomplete()
                        ->autofocus()
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('Supplier Name')
                        ->maxLength(50),
                        \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('company_address')
                        ->label('Company/Address')
                        ->disableAutocomplete()
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('Company/Address')
                        ->maxLength(100),
                            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('business_permit_number')
                        ->label("Business/Mayors's Permit Number")
                        ->disableAutocomplete()
                        ->columnSpanFull()
                        ->required()
                        ->placeholder("Business/Mayors's Permit Number")
                        ->maxLength(50),
                            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('tin')
                        ->label('Tax Identification Number (TIN)')
                        ->disableAutocomplete()
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('Tax Identification Number (TIN)')
                        ->maxLength(50),
                            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('philgeps_registration_number')
                        ->label('PhilGEPS Registration Number')
                        ->disableAutocomplete()
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('PhilGEPS Registration Number')
                        ->maxLength(50),

                            ])

                            ])->columnSpan(2)
                ]),
            Wizard\Step::make('Contact Details')
            ->icon('heroicon-s-phone')
            ->description('Please input contact details')
                ->schema([
                    Grid::make()
        ->schema([
        \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('representative_name')
        ->label('Representative Name')
        ->disableAutocomplete()
        ->required()
        ->columnSpanFull()
        ->hint('Full name, including middle initials.')
        ->placeholder('Representative Name')
        ->maxLength(100),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('position_designation')
        ->label('Position/Designation')
        ->disableAutocomplete()
        ->required()
        ->columnSpanFull()
        ->hint('Ex. Manager, Assistant, Owner, etc.')
        ->placeholder('Position/Designation')
        ->maxLength(50),

            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('office_contact')
        ->label('Office Contact No./Fax/Mobile')
        ->disableAutocomplete()
        ->required()
        ->columnSpanFull()
        ->placeholder('Office Contact No./Fax/Mobile')
        ->maxLength(50),
            \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('email')
        ->label('Email Address/es')
        ->disableAutocomplete()
        ->email()
        ->required()
        ->columnSpanFull()
        ->hint('Ex. example@email.com')
        ->placeholder('Email Address/es')
        ->maxLength(50),
        ]),
                ]),
            ])->columnSpan(2)->skippable(),





            Section::make('Category')
            ->description('Select category from the list below.')
            ->schema([
                Forms\Components\Select::make('category_id')
                ->relationship('category', 'name', fn (Builder $query) => $query->where('hidden', 0))
                ->label('Category Name')

                ->required()
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                    ->label('Category Name')
                    ->disableAutocomplete()
                    ->required()
                    ->placeholder('Category Name'),


                ])
                ->preload()
                ,
            ])->columnSpan(1),


    ])

    ])]);
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
    public static function getWidgets(): array
    {
        return [
            SupplierOverview::class
        ];
    }

}
