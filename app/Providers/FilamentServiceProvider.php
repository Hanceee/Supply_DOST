<?php

namespace App\Providers;

use App\Models\ServerEmail;
use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;

use Filament\Navigation\UserMenuItem;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use FilamentQuickCreate\Facades\QuickCreate;
use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\ServerEmailResource;
use Z3d0X\FilamentLogger\Resources\ActivityResource;

class FilamentServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {


        Filament::registerViteTheme('resources/css/filament.css');
        Filament::serving(function() {
            QuickCreate::excludes([
                \App\Filament\Resources\RoleResource::class,
                ActivityResource::class,
                ServerEmailResource::class

            ]);
        });

        Filament::serving(function () {
            $user = auth()->user();

            if ($user && $user->is_admin === 1 && $user->hasAnyRole(['super-admin'])) {
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                        ->label('Manage Users')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-users'),

                ]);
            }
        });
    }
}
