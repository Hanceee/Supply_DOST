<?php

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\ServerEmailResource;
use Z3d0X\FilamentLogger\Resources\ActivityResource;

return [
    'includes' => [
        // App\Filament\Resources\Blog\AuthorResource::class,
    ],
    'excludes' => [
         ActivityResource::class,
         RoleResource::class,
         ServerEmailResource::class

    ],

    'should_convert_count' => true,
    'enable_convert_tooltip' => true,
];
