<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            // User management
            'user_create',
            'user_edit',
            'user_delete',
            'user_view',
            
            // Menu management
            'menu_manage',
            
            // Order management
            'order_create',
            'order_edit',
            'order_view',
            'order_delete',
            
            // Cashier management
            'cashier_manage',
            'payment_process'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $cashierRole = Role::create(['name' => 'caissier']);
        $cashierRole->givePermissionTo([
            'order_view',
            'payment_process',
            'cashier_manage'
        ]);

        $serverRole = Role::create(['name' => 'serveur']);
        $serverRole->givePermissionTo([
            'order_create',
            'order_edit',
            'order_view'
        ]);
    }

}


    