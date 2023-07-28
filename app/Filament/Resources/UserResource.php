<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Livewire\Livewire;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use BaconQrCode\Renderer\RendererStyle\Fill;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Admin Management';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()

    ->schema([
        Forms\Components\TextInput::make('name')
        ->required()
        ->maxLength(255)
        ->disableAutocomplete()
        ->helperText(' Full name here, including any middle names.'),
        Forms\Components\TextInput::make('email')
        ->email()
        ->required()
        ->disableAutocomplete()
        ->maxLength(255),
        Forms\Components\TextInput::make('username')
        ->required()
        ->disableAutocomplete()
        ->maxLength(255),

  Toggle::make('is_admin')
        ->required()
        ->default(true)
        ->hidden(),

    Forms\Components\TextInput::make('password')
        ->default('password')
        ->required()
        ->minLength(8)
        ->helperText('8 Characters or more.')
        ->dehydrateStateUsing(static fn(null|string $state):
            null|string =>
            filled($state) ? Hash::make($state): null,
    )->required(static fn (Page $livewire): string =>
       $livewire instanceof CreateUser,
    )->dehydrated(static fn(null|string $state): bool =>
            filled($state),
        )->label(static fn(PAge $livewire): string =>
            ($livewire instanceof EditUser) ? 'New Password' : 'Password'
        ),
    CheckboxList::make('roles')
        ->relationship('roles', 'name')
        ->columns(2)
        ->helperText('Only Choose One!')
        ->required(),
    ])->columns(1)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('username')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),
                TextColumn::make('is_admin')
                     ->sortable()
                    ->searchable(),
                    TextColumn::make('roles.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('delete_at')
                ->dateTime('d-M-Y')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d-M-Y')
                ->sortable()
                ->searchable(),

            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
