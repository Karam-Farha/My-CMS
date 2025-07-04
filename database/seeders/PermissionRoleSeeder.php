<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // preparing admin Role permissions
        $adminPermissions = Permission::all();
        $adminRole = Role::where('name' , 'Admin')->first();
        $adminRole->permissions()->sync($adminPermissions);


        $userRole = Role::where('name' , 'User')->first();
        $includedPermissions = ['dashboard_access'];
        $userPermissions = Permission::whereIn('name' , $includedPermissions)->get();
        $userRole->permissions()->sync($userPermissions);
    }
}
