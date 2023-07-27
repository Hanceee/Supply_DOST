<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;



class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $miscPermission = Permission::create(['name' => 'N/A']);

    $userPermission1 = Permission::create(['name' => 'create: user']);
    $userPermission2 = Permission::create(['name' => 'read: user']);
    $userPermission3 = Permission::create(['name' => 'update: user']);
    $userPermission4 = Permission::create(['name' => 'delete: user']);

    $rolePermission1 = Permission::create(['name' => 'create: role']);
    $rolePermission2 = Permission::create(['name' => 'read: role']);
    $rolePermission3 = Permission::create(['name' => 'update: role']);
    $rolePermission4 = Permission::create(['name' => 'delete: role']);

    $Permission1 = Permission::create(['name' => 'create: permission']);
    $Permission2 = Permission::create(['name' => 'read: permission']);
    $Permission3 = Permission::create(['name' => 'update: permission']);
    $Permission4 = Permission::create(['name' => 'delete: permission']);

    $adminPermission1 = Permission::create(['name' => 'read: admin']);
    $adminPermission2 = Permission::create(['name' => 'update: admin']);


    $superAdminRole = Role::create(['name' => 'super-admin'])->syncPermissions([
        $userPermission1,
        $userPermission2,
        $userPermission3,
        $userPermission4,
        $rolePermission1,
        $rolePermission2,
        $rolePermission3,
        $rolePermission4,
        $Permission1,
        $Permission2,
        $Permission3,
        $Permission4,
        $adminPermission1,
        $adminPermission2,
        $userPermission1,
    ]);

    $adminRole = Role::create(['name' => 'admin'])->syncPermissions([
        $miscPermission
    ]);


    User::create([
        'name' => 'super admin',
        'is_admin' => 1,
        'email' => 'super@admin.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
    ])->assignRole($superAdminRole);


    User::create([
        'name' => 'admin',
        'is_admin' => 1,
        'email' => 'admin@admin.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
    ])->assignRole($adminRole);

}

}
