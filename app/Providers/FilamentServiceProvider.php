<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Spatie\Permission\Contracts\Role;

use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\PermissionResource;
use CmsMulti\FilamentClearCache\Facades\FilamentClearCache;

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
