<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;

use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\CategoryResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\CategoryResource\RelationManagers\SupplierRelationManager;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationGroup = 'Supplier Management';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form

                ->schema([

                    Card::make()
                    ->schema([
                         \Wiebenieuwenhuis\FilamentCharCounter\TextInput::make('name')
        ->label('Category Name')
        ->required()
        ->hint('Ex. Automotive, Electronics, Grocery, etc.')
        ->placeholder('Category')
        ->maxLength(20)
                    ])    ->inlineLabel()






            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Split::make([
                    BadgeColumn::make('name')->label('Category Name')->searchable()
                ->icons([
                    'heroicon-o-folder',
                ])
                ->colors([
                    'success',
                ])
                ,
                Tables\Columns\TextColumn::make('supplier_count')->counts('supplier')->sortable()->icon('heroicon-o-truck'),
                ToggleIconColumn::make('hidden')
                ->label('Toggle Visibility')
                ->alignCenter()
                ->onColor('secondary')
                ->offColor('warning')
                ->onIcon('bi-eye-slash-fill')
                ->offIcon('bi-eye-fill')
                ,
                ]),
                Panel::make([
                    Stack::make([
                Tables\Columns\TextColumn::make('created_at')->sortable()
                    ->dateTime()->formatStateUsing(fn (string $state): string => __("Created at {$state}")),
                Tables\Columns\TextColumn::make('updated_at')->sortable()
                    ->dateTime()->formatStateUsing(fn (string $state): string => __("Updated at {$state}")),
                    ]),
                ])->collapsible(),





            ])
            ->filters([
                Filter::make('created_at')
    ->form([
        Forms\Components\DatePicker::make('created_from'),
        Forms\Components\DatePicker::make('created_until')->default(now()),
    ]),
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('Visibility')
                ->options([
                    '0' => 'Shown',
                    '1' => 'Hidden',
                ])->attribute('hidden')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ForceDeleteAction::make(),]),

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
            SupplierRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
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
